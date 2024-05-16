import React, { useState } from 'react';
import ReactDOM from 'react-dom'
import toast from 'react-hot-toast';

const LeadForm = ({ visible, onClose, countries, phoneCodes, categories, prospectTypes }) => {

    const [personName, setPersonName] = useState('');
    const [email, setEmail] = useState('');
    const [phone, setPhone] = useState('');
    const [website, setWebsite] = useState('');
    const [lookingFor, setLookingFor] = useState('none');
    const [businessName, setBusinessName] = useState('');
    const [inquiryMessage, setInquiryMessage] = useState('');

    const [category, setCategory] = useState('none');
    const [country, setCountry] = useState('none');
    const [phoneCode, setPhoneCode] = useState('none');
    const [errorBag, setErrorBag] = useState({});

    const validate = () => {
        let errors = {};
        setErrorBag({});
        if(personName === '')
        {
            errors.personName = 'Your name is required';  
        }

        if(email === '')
        {
            errors.email = 'Your email is required';  
        }

        if(phoneCode === 'none' && phone !== '' )
        {
            errors.phone = 'Please enter both the country code and the phone number';  
        }

        if(phone === '' && phoneCode !== 'none')
        {
            errors.phone = 'Please enter both the country code and the phone number';  
        }

        if(category === 'none')
        {
            errors.category = 'Please select your interested category';  
        }

        if(country === 'none')
        {
            errors.country = 'Please select your country';  
        }

        if(businessName === '')
        {
            errors.businessName = 'Business name is required';  
        }

        if(lookingFor === 'none')
        {
            errors.lookingFor = 'Please select who you\'re looking to meet';  
        }

        if(Object.keys(errors).length > 0)
        {
            setErrorBag(errors);
            return false;
        }

        return true;
    };

    const submit = () => {
        const isValid = validate();
        if(isValid)
        {
            axios.post('/leads', {
                person_name: personName,
                email: email,
                phone: phone,
                website: website,
                country_id: country === 'none' ? null : country,
                phone_code: phoneCode === 'none' ? null : phoneCode,
                category_id: category === 'none' ? null : category,
                business_name: businessName,
                inquiry_message: inquiryMessage,
                looking_for: lookingFor === 'none' ? null : lookingFor
            })
            .then((response) => {
              toast.success('We\'ve successfully recieved your inquiry, \nA agent will contact you shortly!', {
                  duration: 4000
              });
              close();
            })
            .catch((error) => {
                let errors = {};
                setErrorBag({});
        
                if(error.response.status === 422)
                {
                    if(Object.entries(error.response.data.errors).length > 0)
                    {
                        Object.entries(error.response.data.errors).forEach((entry) => {
                            if(entry[0] === 'person_name')
                            {
                                errors.personName = entry[1][0];
                            }
                            if(entry[0] === 'email')
                            {
                                errors.email = entry[1][0];
                            }
                            if(entry[0] === 'phone')
                            {
                                errors.phone = entry[1][0];
                            }
                            if(entry[0] === 'website')
                            {
                                errors.website = entry[1][0];
                            }
                            if(entry[0] === 'country_id')
                            {
                                errors.country = entry[1][0];
                            }
                            if(entry[0] === 'category_id')
                            {
                                errors.category = entry[1][0];
                            }
                            if(entry[0] === 'business_name')
                            {
                                errors.businessName = entry[1][0];
                            }
                            if(entry[0] === 'inquiry_message')
                            {
                                errors.inquiryMessage = entry[1][0];
                            }
                            if(entry[0] === 'looking_for')
                            {
                                errors.lookingFor = entry[1][0];
                            }
                        });

                        if(Object.keys(errors).length > 0)
                        {
                            setErrorBag(errors);
                            return false;
                        }
                    }
                }
            });
        }
    };

    const close = () => {
        onClose();
    };

    return (
        ReactDOM.createPortal(
            <div className={`transition-opacity duration-150 lead-modal fixed w-full h-full top-0 left-0 flex justify-center items-center bg-black-200 ${visible ? 'opacity-100 z-50' :  'opacity-0 hidden'}`} >
            <div className="flex flex-col w-11/12 sm:w-5/6 lg:w-1/2 max-w-2xl mx-auto rounded-lg border border-gray-300 shadow-xl h-4/6">
                <div className="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
                    <p className="font-semibold text-gray-800">Send an inquiry</p>
                    <svg
                        onClick={close}
                        className="w-6 h-6 cursor-pointer"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </div>
                <div className="flex flex-col px-6 py-5 bg-gray-50 overflow-y-auto overflow-x-hidden">
                    <div className="h-full">
                        <p className="my-2 font-semibold text-gray-700 required">Your name</p>
                        <input
                            onChange={e => setPersonName(e.target.value)}
                            type="text"
                            value={personName}
                            placeholder="Your name"
                            className="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                        ></input>
                        {
                            errorBag.hasOwnProperty('personName') &&
                            <p className="font-semibold text-red-700">{errorBag.personName}</p>
                        }

                    <p className="my-2 font-semibold text-gray-700 required">Email</p>
                    <input
                        onChange={e => setEmail(e.target.value)}
                        type="email"
                        placeholder="Your email"
                        className="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                        value={email}
                    ></input>
                    {
                        errorBag.hasOwnProperty('email') &&
                        <p className="font-semibold text-red-700">{errorBag.email}</p>
                    }

                    <p className="my-2 font-semibold text-gray-700 required">Phone number</p>
                    <div className="flex gap-2">
                        <select
                            onChange={e => setPhoneCode(e.target.value)}
                            placeholder="--"
                            className="flex-none w-15 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                            value={phoneCode}
                        >
                            <option value='none'>--</option>
                            {
                                Object.entries(phoneCodes).map((phoneCode)=> (
                                    <option value={phoneCode[0]} key={phoneCode[0]}> + {phoneCode[1]} </option>
                                ))
                            }
                        </select>
                        <input
                            onChange={e => setPhone(e.target.value)}
                            type="text"
                            placeholder="Your number"
                            className="flex-grow-0 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                            value={phone}
                        ></input>
                    </div>
                    {
                        errorBag.hasOwnProperty('phone') &&
                        <p className="font-semibold text-red-700">{errorBag.phone}</p>
                    }

                    <p className="mb-2 font-semibold text-gray-700 required">Country</p>
                    <select onChange={(e) => setCountry(e.target.value)} value={country} className='mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2'>
                        <option value='none'>Select your country</option>
                        {
                            Object.entries(countries).map((entry) => (
                                <option value={entry[0]} key={entry[0]} >{entry[1]}</option>
                            ))
                        }
                    </select>
                    {
                        errorBag.hasOwnProperty('country') &&
                        <p className="font-semibold text-red-700">{errorBag.country}</p>
                    }

                    <p className="mb-2 font-semibold text-gray-700 required">Category</p>
                    <select onChange={(e) => setCategory(e.target.value)} value={category} className='mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2'>
                        <option value='none'>Select interested category</option>
                        {
                            Object.entries(categories).map((entry) => (
                                <option value={entry[0]} key={entry[0]} >{entry[1]}</option>
                            ))
                        }
                    </select>
                    {
                        errorBag.hasOwnProperty('category') &&
                        <p className="font-semibold text-red-700">{errorBag.category}</p>
                    }

                    <p className="my-2 mt-3 font-semibold text-gray-700">Website</p>
                    <input
                        type="url"
                        onChange={e => setWebsite(e.target.value)}
                        placeholder="Your business website"
                        value={website}
                        className="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                    ></input>
                    {
                        errorBag.hasOwnProperty('website') &&
                        <p className="font-semibold text-red-700">{errorBag.website}</p>
                    }

                    <p className="mb-2 font-semibold text-gray-700 required">Looking to meet</p>
                    <select onChange={(e) => setLookingFor(e.target.value)} value={lookingFor} className='mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2'>
                        <option value='none'>Select a prospect type</option>
                        {
                            Object.entries(prospectTypes).map((entry) => (
                                <option value={entry[0]} key={entry[0]} >{entry[1]}</option>
                            ))
                        }
                    </select>
                    {
                        errorBag.hasOwnProperty('lookingFor') &&
                        <p className="font-semibold text-red-700">{errorBag.lookingFor}</p>
                    }

                    <p className="my-2 mt-3 font-semibold text-gray-700 required">Business name</p>
                    <input
                        type="text"
                        onChange={e => setBusinessName(e.target.value)}
                        placeholder="Your business name"
                        value={businessName}
                        className="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                    ></input>
                    {
                        errorBag.hasOwnProperty('businessName') &&
                        <p className="font-semibold text-red-700">{errorBag.businessName}</p>
                    }

                    <p className="my-2 mt-3 font-semibold text-gray-700">Inquiry message</p>
                    <textarea
                    onChange={e => setInquiryMessage(e.target.value)}
                    value={inquiryMessage}
                        rows="10"
                        placeholder="Your inquiry"
                        className="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md h-40 mb-2"
                   ></textarea>
                    {
                        errorBag.hasOwnProperty('inquiryMessage') &&
                        <p className="font-semibold text-red-700">{errorBag.inquiryMessage}</p>
                    }

                </div>
            </div>
            <div className="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg">
                <p onClick={close} className="cursor-pointer rounded  text-sm mt-2 font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-sm ">Cancel</p>
                <button type="button" onClick={submit} className="cursor-pointer rounded  text-sm mt-2 font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-primary hover:bg-primary_hover text-white rounded-sm ">
                    Send
                </button>
            </div>
        </div>
            </div>,
            document.getElementById('inquiry-modal')
        )
    );
}

export default LeadForm;
