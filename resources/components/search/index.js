/**
 * Shehan jayasinghe 05/06/2021
 * Search component
**/

import React, { useState, useEffect, useRef } from 'react';
import ReactDOM from 'react-dom';
import Filter from './filter';
import axios from 'axios';
import ProductList from './productList';
import Paginator from './paginator';
import * as QueryString from "query-string"
import LeadForm from './leadForm';
import { Toaster } from 'react-hot-toast';
import moment from 'moment-timezone';
import placeholder from '../../../public/img/placeholder/25be2b86a12dbfd8da02db4cfcbfe50a.jpg';
import fillprofile from '../../../public/img/placeholder/25e27f1e-9eb2-4dbf-bf44-38e1a7dc516d.png';

const Search = () => {

   const [loading, setLoading] = useState(false);
   const [initialized, setInitialized] = useState(false);
   const [categories, setCategories] = useState([]);
   const [countries, setCountries] = useState([]);
   const [phoneCodes, setPhoneCodes] = useState([]);
   const [designations, setDesignations] = useState([]);
   const [prospectTypes, setProspectTypes] = useState([]);
   const [companyTypes, setCompanyTypes] = useState([]);
   const [products, setProducts] = useState([]);
   const [relatedProducts, setRelatedProducts] = useState([]);
   const [gridType, setGridType] = useState(0);
   const [currentFilters, setCurrentFilters] = useState([]);
   const [totalProducts, setTotalProducts] = useState(0);
   const [filterVisible, setFilterVisible] = useState(false);
   const filterBox = useRef(null);
   const [paginationLinks, setPaginationLinks] = useState([]);
   const [currentPaginationLevel, setCurrentPaginationLevel] = useState(1);
   const [curentDomain, setCurrentDomain] = useState('default');
   const [isAuthenticated, setIsAuthenticated] = useState(false);
   const [hasBusiness, setHasBusiness] = useState(true);

   const [leadFormVisible, setLeadFormVisible] = useState(false);

   useEffect(() => {
        var domain = /:\/\/([^\/]+)/.exec(window.location.href)[1];
        setCurrentDomain(domain);

        if(initialized)
        {
            let defaultFilters = [];
            const parsed = QueryString.parse(location.search);
            let searchParameters = {};

            if(parsed.keyword)
            {
                searchParameters.keywords = parsed.keyword
                defaultFilters['keywords'] = parsed.keyword;
            }

            if(parsed.availability && parsed.availability.length > 0)
            {
                searchParameters.availability = parsed.availability
                defaultFilters['availability'] = parsed.availability;
            }

            if(parsed.country)
            {
                searchParameters.country_id = parsed.country
                defaultFilters['country'] = parsed.country;
            }

            setCurrentFilters(defaultFilters);

            if(Object.keys(searchParameters).length > 0)
            {
                handleSearch(searchParameters);
            }
            else
            {
                searchParameters.current_domain = curentDomain;
                handleSearch(searchParameters);
            }
        }
    }, [initialized]);

   useEffect(() => {
       //getApidata
       setLoading(true);
        axios.post('/search/filters', null)
        .then((response) => {
            setTimeout(() => {
                setCategories(response.data.categories);
                setCountries(response.data.countries);
                setDesignations(response.data.designations);
                setCompanyTypes(response.data.company_types);
                setProspectTypes(response.data.prospect_types);
                setPhoneCodes(response.data.phone_codes);
                setLoading(false);
                setInitialized(true);

            }, 2000);

        })
        .catch((error) => {
            setLoading(false);
        })
   }, []);

   const handleSearch = (parameters = [], url = '/search') => {
        setCurrentFilters(parameters);
        setLoading(true);
        parameters['current_domain'] = curentDomain;
        axios.post(url, parameters)
            .then((response) => {
                setRelatedProducts(response.data.related_products.data);
                setProducts(response.data.products.data);
                setPaginationLinks(response.data.products.meta.links);
                setCurrentPaginationLevel(response.data.products.meta.current_page);
                setTotalProducts(response.data.products.meta.total);

                setIsAuthenticated(response.data.authenticated);

                setLoading(false);
            })
            .catch((error) => {
                setLoading(false);
                if(error.response.data.message === 'user has no business')
                {
                    setHasBusiness(false);
                }
            })
        setFilterVisible(false)
   };

    const toggleListType = (type) => {
        setGridType(type)
    };

    const handleFormClose = () => {
        setLeadFormVisible(false);
    };

    const handleFormOpen = () => {
        setLeadFormVisible(true);
    };

    const handlePaginationUpdate = (url) => {
        handleSearch(currentFilters, url);
    };

    return (
        <div className="container mx-auto md:px-8 px-4 ">
            <Toaster />
            <div className="flex items-center justify-between pt-24 md:pl-72 mx-3 ">
                <div className="flex md:flex-row flex-col-reverse md:items-center items-end justify-between w-full">
                    <div className="flex md:flex-row flex-col-reverse items-center justify-between w-full">
                        {
                            initialized &&
                            <>
                                <div className="flex-col flex mr-auto">
                                    {
                                        !loading &&
                                        <h3 className="text-gray-500 text-base cursor-pointer truncate" style={{maxWidth: '30em'}}>{totalProducts} results available 
                                        {
                                            currentFilters.keywords !== undefined &&
                                            <span> for {currentFilters.keywords}</span>
                                        }
                                        </h3>
                                    }

                                    <span className='text-xs text-gray-500'>Current timezone is {moment.tz.guess()}</span>
                                </div>
                                <p className='text-base  ml-auto'>Can't find what you're looking for? Click <a onClick={handleFormOpen} className='cursor-pointer text-primary hover:text-primary_hover font-bold'>here</a> to send us a inquiry</p>
                            </>
                        }
                    </div>
                    <div className="flex items-center mb-3 md:mb-0 w-max">
                        <span className="cursor-pointer mr-2 md:hidden p-2 px-3 bg-gray-300 hover:bg-gray-400 flex rounded" onClick={() => setFilterVisible(!filterVisible)}>
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinecap="round" strokeWidth="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <span className="ml-1">Filter</span>
                        </span>
                    </div>
                </div>
            </div>
            <div className="flex items-start flex-col md:flex-row ">
                <div className="md:w-max w-full ">
                    <div className={`md:w-72 w-full px-3 py-4 md:py-0 transition-all duration-200 ease-in-out ${ filterVisible ? 'block' : 'hidden md:block'}`} ref={filterBox}>
                        <Filter defaultFilters={currentFilters} categories={categories} companyTypes={companyTypes} countries={countries} designations={designations} onSearchInitiated={handleSearch} prospectTypes={prospectTypes}/>
                    </div>
                </div>
                <div  className="w-full p-3 ">
                    {
                        loading &&
                       <>
                          <ProductList gridType={gridType} list={products} loading={loading} showPricing={isAuthenticated}/>
                       </>
                    }
                     {
                        (products.length === 0 && !loading && !hasBusiness) &&
                        <div className={`product-list-container w-full mt-5  justify-center items-center flex flex-col`}>
                            <img src={fillprofile} style={{height: '400px', width: '500px'}} className="shadow-md rounded bg-white"></img>
                            <p className="mt-4 text-xl">Looks like you haven't completed your business profile</p>
                            <p>Please complete your business profile by clicking <a className="text-blue-400 font-bold cursor-pointer" href='/onboarding?skip_card=true'>here</a> before browsing any requirements.</p>
                        </div>
                    }
                    {
                        (products.length === 0 && !loading && hasBusiness) &&
                        <div className={`product-list-container w-full mt-5  justify-center items-center flex flex-col`}>
                            <img src={placeholder} style={{height: '400px', width: '500px'}} className="shadow-md rounded"></img>
                            <p className="mt-4">Cannot find the prospects you are looking for?</p>
                            <p>Let us know who you want to meet by clicking <a className="text-blue-400 font-bold cursor-pointer" onClick={handleFormOpen}>here</a> and we will get in touch and arrange a meeting.</p>
                        </div>
                    }
                    {
                        (products.length !== 0) && 
                        <>
                        <ProductList gridType={gridType} list={products} loading={loading} showPricing={isAuthenticated}/>
                        {
                            (!loading && totalProducts !== 0) &&
                            <Paginator paginationLevels={paginationLinks} paginationLevel={currentPaginationLevel} onChange={handlePaginationUpdate}/>
                        }
                        </>
                    }
                     {
                        (products.length === 0 && relatedProducts.length !== 0 && !loading) &&
                        <div className="flex flex-col justify-center items-center mt-14">
                            <p className="mt-2 text-center">Related products you might be interested in</p>
                            <div className="overflow-x-auto" style={{width: '60rem'}}>
                                <div className="flex items-center gap-4 pb-4">
                                {
                                    relatedProducts.map((data, i) => (
                                        <a href={data.link} className="cursor-pointer" key={i}>
                                            <div className="py-4 px-5 bg-white shadow-md rounded-md w-full flex flex-col gap-1">
                                                <p className="font-semibold truncate whitespace-nowrap text-primary">{data.name}</p>
                                                <p className="text-xs text-gray-600">
                                                {
                                                    (data.looking_to_meet !== '' && data.looking_from !== '') &&
                                                    <span className="text-xs normal-case text-gray-600">Looking to meet {data.looking_to_meet} from {data.looking_from.replace("_"," ")}</span>
                                                }
                                                {
                                                    (data.looking_to_meet !== '' && data.looking_from === '') &&
                                                    <span className="text-xs normal-case text-gray-600">Looking to meet {data.looking_to_meet} from anywhere</span>
                                                }
                                                {
                                                    (data.looking_to_meet === '' && data.looking_from !== '') &&
                                                    <span className="text-xs normal-case text-gray-600">Looking to meet prospects from {data.looking_from.replace("_"," ")}</span>

                                                }
                                                </p>
                                                <p className="text-sm">{data.price} USD ( Pay after meeting )</p>
                                                <div className="flex items-start rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" stroke-linejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p className="text-xs ml-2 text-gray-600 truncate" >
                                                    
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    ))
                                }
                                </div>
                            </div>
                        </div>
                    }
                   
                </div>
            </div>

            <LeadForm countries={countries} phoneCodes={phoneCodes} categories={categories} visible={leadFormVisible} prospectTypes={prospectTypes} onClose={handleFormClose}/>
        </div>
    );
}

if (document.getElementById('search-container')) {
    ReactDOM.render(<Search />, document.getElementById('search-container'));
}
