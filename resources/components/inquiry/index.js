/**
 * Shehan jayasinghe 05/06/2021
 * Search component
**/

import React, { useState, useEffect, useRef } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import * as QueryString from "query-string"
import LeadForm from './leadForm';


const Inquiry = () => {

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
   const [curentDomain, setCurrentDomain] = useState('default');

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

            // if(Object.keys(searchParameters).length > 0)
            // {
            //     handleSearch(searchParameters);
            // }
            // else
            // {
            //     searchParameters.current_domain = curentDomain;
            //     handleSearch(searchParameters);
            // }
        }
    }, [initialized]);

   useEffect(() => {
       //getApidata
       setLoading(true);
        axios.post('/search/filters', null)
        .then((response) => {
          
                setCategories(response.data.categories);
                setCountries(response.data.countries);
                setDesignations(response.data.designations);
                setCompanyTypes(response.data.company_types);
                setProspectTypes(response.data.prospect_types);
                setPhoneCodes(response.data.phone_codes);
                setLoading(false);
                setInitialized(true);
       

        })
        .catch((error) => {
            setLoading(false);
        })
   }, []);



    const toggleListType = (type) => {
        setGridType(type)
    };

    const handleFormClose = () => {
        setLeadFormVisible(false);
    };

    const handleFormOpen = () => {
        setLeadFormVisible(true);
    };

    return (
       <div>
         {
                <>
                    <button type="button" onClick={handleFormOpen} className="py-3 px-9 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary lg:hover:text-white hover:border-primary lg:hover:bg-primary dark:hover:text-red-400 lg:border border-gray-700 lg:px-5 lg:py-2 transition-all duration-150 ease-in-out cursor-pointer">
                     Contact Us
                    </button>
                </>
            }

            <LeadForm countries={countries} phoneCodes={phoneCodes} categories={categories} visible={leadFormVisible} prospectTypes={prospectTypes} onClose={handleFormClose}/>
        </div>
    );
}

if (document.getElementById('inquiry-container')) {
    ReactDOM.render(<Inquiry />, document.getElementById('inquiry-container'));
}
