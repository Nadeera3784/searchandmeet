import React, { useState, useCallback, useEffect } from 'react';
import Select from 'react-select';
import './filter.css';

const Filter = ({ defaultFilters, categories = {}, companyTypes = {}, countries = {}, designations = [], onSearchInitiated, prospectTypes = {} }) => {

    const [keywords, setKeywords] = useState('');
    const [availability, setAvailability] = useState([]);
    const [maxPrice, setMaxPrice] = useState('none');
    const [minPrice, setMinPrice] = useState('none');
    const [companyType, setCompanyType] = useState('none');
    const [designation, setDesignation] = useState('none');
    const [category, setCategory] = useState('none');
    const [country, setCountry] = useState('none');
    const [prospectType, setProspectType] = useState('none');

    useEffect(() => {
        if (defaultFilters['country']) {
            setCountry(defaultFilters['country']);
        }

        if (defaultFilters['category']) {
            setCategory(defaultFilters['category']);
        }

        if (defaultFilters['keywords']) {
            setKeywords(defaultFilters['keywords']);
        }

        if (defaultFilters['availability']) {
            setAvailability(defaultFilters['availability']);
        }
    }, [defaultFilters]);

    const clearFilters = () => {
        setKeywords('');
        setAvailability([]);
        setMaxPrice('none');
        setMinPrice('none');
        setCompanyType('none');
        setDesignation('none');
        setCategory('none');
        setCountry('none');
    };

    const filterAvailability = (filter) => {
        let updates = availability ? availability : [];
        const hasFilter = updates.find((item) => item === filter);
        if (hasFilter) {
            updates = updates.filter((item) => item !== filter);
        }
        else {
            updates = [...updates, filter];
        }

        setAvailability(updates);
    };

    const getOptions = (unformattedObj) => {
        unformattedObj['none'] = 'Select an option';
        return Object.entries(unformattedObj).map((entry) => {
            return {
                value: entry[0],
                label: entry[1]
            }
        });
    }

    const getOption = (unformattedObj, value) => {
        return getOptions(unformattedObj).find((option) => option.value == value);
    }

    const search = () => {
        try {
            validate();
            onSearchInitiated({
                keywords: keywords === '' ? undefined : keywords,
                availability: availability === [] ? undefined : availability,
                maxPrice: maxPrice === 'none' ? undefined : maxPrice,
                minPrice: minPrice === 'none' ? undefined : minPrice,
                companyType: companyType === 'none' ? undefined : companyType,
                category_id: category === 'none' ? undefined : category,
                designation: designation === 'none' ? undefined : designation,
                country_id: country === 'none' ? undefined : country,
                prospect_type: prospectType === 'none' ? undefined : prospectType,
            });
        }
        catch (error) {
            //invalid
        }
    };

    const validate = () => {

    }


    const customStyles = {
        control: base => ({
            ...base,
            border: '1px solid #cccccc',
            boxShadow: 'none',
            '&:hover': {
                border: '1px solid #cccccc',
            }
        })
    };

    return (
        <div className="filter-container font-secondary ">
            <div className="w-full">
                <form action="">
                    <p className="text-lg text-gray-900">Search Keywords </p>
                    <div className="grid gap-2 grid-cols-1 grid-rows-1 mt-1">
                        <input type='text' value={keywords} onChange={(e) => setKeywords(e.target.value)} placeholder='Enter search keywords' className='text-sm  rounded px-3 py-2 transition duration-150 ease-in-out border-0 outline-none shadow-md focus:border-blue:500 focus:outline-none focus:ring-0' />
                    </div>

                    <p className="text-lg text-gray-900 mt-5">Availability</p>
                    <div className="grid gap-2 grid-cols-1 w-full mt-1">
                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('today')} checked={availability.includes('today') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer ">Today</span>
                        </label>

                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('tomorrow')} checked={availability.includes('tomorrow') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer ">Tomorrow</span>
                        </label>

                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('week')} checked={availability.includes('week') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer ">This Week</span>
                        </label>

                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('thisMonth')} checked={availability.includes('thisMonth') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer ">This Month</span>
                        </label>

                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('nextMonth')} checked={availability.includes('nextMonth') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer  ">Next Month</span>
                        </label>

                        <label className="width-fit-content">
                            <input type='checkbox' onChange={() => filterAvailability('all')} checked={availability.includes('all') ? 'checked' : ''} className='text-sm form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray' />
                            <span className="ml-3  cursor-pointer ">All</span>
                        </label>
                    </div>

                    <p className="text-lg text-gray-900 mt-5">Country</p>
                    <Select options={getOptions(countries)} classNamePrefix="select" styles={customStyles} className='block w-full mt-3' value={getOption(countries, country)} isSearchable={true} isClearable={true} onChange={(option) => setCountry(option.value)} placeholder="Select Country" />

                    <p className="text-lg text-gray-900 mt-5">Category</p>
                    <Select options={getOptions(categories)} classNamePrefix="select" styles={customStyles} className='block w-full mt-3' value={getOption(categories, category)} isSearchable={true} isClearable={true} onChange={(option) => setCategory(option.value)} placeholder="Select Category" />

                    <p className="text-lg text-gray-900 mt-5">Looking To Meet</p>
                    <Select options={getOptions(prospectTypes)} classNamePrefix="select" styles={customStyles} className='block w-full mt-3' value={getOption(prospectTypes, prospectType)} isSearchable={true} isClearable={true} onChange={(option) => setProspectType(option.value)} />

                    <p className="text-lg text-gray-900 mt-5">Business Type</p>
                    <Select options={getOptions(companyTypes)} classNamePrefix="select" styles={customStyles} className='block w-full mt-3 form-control' value={getOption(companyTypes, companyType)} isSearchable={true} isClearable={true} onChange={(option) => setCompanyType(option.value)} placeholder="Select Business Type" />


                    <p className="text-lg text-gray-900 mt-5">Job Title</p>
                    <Select options={getOptions(designations)} classNamePrefix="select" styles={customStyles} className='block w-full mt-3' value={getOption(designations, designation)} isSearchable={true} isClearable={true} onChange={(option) => setDesignation(option.value)} placeholder="Select Job Title" />

                    <p className="text-lg text-gray-900 mt-5">Purchase Value USD </p>
                    <div className="grid gap-2 grid-cols-2 grid-rows-1 mt-1 ">
                        <input type='number' value={minPrice} onChange={(e) => setMinPrice(e.target.value)} placeholder='Min' className='text-sm  rounded px-3 py-2 transition duration-150 ease-in-out border-0 outline-none shadow-md focus:border-blue-500 focus:outline-none focus:ring-0' />
                        <input type='number' value={maxPrice} onChange={(e) => setMaxPrice(e.target.value)} placeholder='Max' className='text-sm  rounded px-3 py-2 transition duration-150 ease-in-out border-0 outline-none shadow-md focus:border-blue-500 focus:outline-none focus:ring-0' />

                    </div>

                    <br />
                    <div className='flex flex-row justify-between mt-5 space-x-3'>
                        <button onClick={clearFilters} className='block w-full text-sm p-2 bg-white hover:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300' type='button'>Clear filters</button>
                        <button onClick={search} className='block w-full text-sm p-2 bg-primary hover:bg-primary_hover text-white border-solid border-0 focus:outline-none rounded' type='button'>Search</button>
                    </div>
                </form>
            </div>
        </div>
    );
}

export default Filter;
