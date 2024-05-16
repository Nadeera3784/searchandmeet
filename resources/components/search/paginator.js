import React, { useState, useEffect, useMemo } from 'react';

const Paginator = ({ paginationLevels, paginationLevel, onChange }) => {

    const callPaginationUrl = (url) => {
        if(url)
        {
            onChange(url);
        }
    }
    return (
        <>
            {
                paginationLevels.length > 0 &&
                <div className='mt-8 mx-auto w-max'>
                    <nav className="relative z-0 inline-flex transform scale-110 justify-center items-center gap-4" aria-label="Pagination">
                    {
                        paginationLevels.map((x, i) => (
                            <a 
                                onClick={() => callPaginationUrl(x.url)} 
                                key={i} 
                                className={`cursor-pointer z-10 font-bold relative justify-center flex w-max px-1.5 h-5 transition-all duration-200 ease-in-out transform hover:scale-125 rounded-full items-center text-xs ${paginationLevel == (x.label) ? 'text-white bg-primary' : ' text-gray-800 hover:text-white hover:bg-primary'}`}>
                                    {
                                        x.label === 'Next &raquo;' &&
                                        <>
                                        <span >Next</span>
                                            <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                            </svg>
                                        </>
                                    }
                                    {
                                        x.label === '&laquo; Previous' &&
                                        <>
                                                <span >Previous</span>
                                            <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd" />
                                            </svg>
                                        </>
                                    }
                                    {
                                        (x.label !== 'Next &raquo;' && x.label !== '&laquo; Previous') &&
                                        <span>{x.label}</span>
                                    }
                            </a>
                        ))
                    }
                    </nav>
                </div>
            }
        </>
    );
}

export default Paginator;
