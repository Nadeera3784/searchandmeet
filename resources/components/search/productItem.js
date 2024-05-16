import React, { useState, useMemo } from 'react';
import moment from 'moment';

const ProductItem = ({data, showPricing}) => {

    // const nextAvailableTimeslot = useMemo(() => {
    //     const today = new Date();
    //     if(data.available_timeslots.length === 0)  return [];
    //     return data.available_timeslots.reduce((a, b) => a.start - today < b.start - today ? a : b);
    // },[data]);

    return (
        <div className="product-item-container cursor-pointer" onClick={() => window.open(data.link,"_self")}>
            <div className="w-full bg-white hover:shadow-lg p-5 mb-5 rounded-lg">
                <div className="w-full flex flex-col justify-between items-start md:flex-row overflow-hidden">
                    <div className="flex items-center flex-row">
                        <div className="flex flex-col gap-1 items-start">
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
                            <p className="text-lg normal-case text-gray-900">{data.name}</p>
                            <p className="text-sm text-gray-500 line-clamp-2">{data.description}</p>
                            {
                                showPricing &&
                                <p className="text-sm text-black-500 font-bold line-clamp-2">{data.price} USD (Pay after meeting)</p>
                                ||
                                <p className="text-sm text-black-500 font-bold line-clamp-2">Login to view pricing</p>
                            }
                          

                            <div className="flex flex-wrap  justify-start items-center mt-2 gap-4">
                                <div className="flex items-center py-1 width-fit-content rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span className="text-black ml-2 text-xs" >{data.country.name}</span>
                                </div>

                                <div className="flex items-center py-1 width-fit-content rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span className="text-black ml-2 text-xs " >{data.category.name}</span>
                                </div>

                                <div className={`flex items-center py-1 width-fit-content rounded`}>
                    
                                </div>

                            </div>
                        </div>
                    </div>
                    <div className="flex flex-col items-end md:ml-auto mt-auto w-full md:w-auto">
                        <a href={data.link} className={`mt-3 sm:mt-0 text-center px-4 py-2 text-sm  sm:w-max w-full text-white rounded text-uppercase whitespace-nowrap ${data.available ? 'bg-primary hover:bg-primary_hover' : 'bg-gray-900 hover:bg-gray-800'}`}>
                            {data.available ? 'Meet Now' : 'Request meeting'}
                        </a>
                    </div>
                </div>
            </div>
     </div>
    );
}

export default ProductItem;
