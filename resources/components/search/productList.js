import React, { useState, useEffect, useMemo } from 'react';
import ProductItem from './productItem';

const ProductList = ({ gridType, list, loading, showPricing = false }) => {

    const [sortedProducts, setSortedProducts] = useState([]);

    const listSize = useMemo(() => {
        return gridType === 1 ? 9 : 15;
    }, [gridType]);

    useEffect(() => {
        // list.sort(sortByAvailability);
        setSortedProducts(list);
    }, [list])

    return (
        <>
            {
                loading &&
                <div className={`product-list-container w-full mt-5`}>
                   {
                    [...Array(listSize)].map((x, i) => (
                            <div className="bg-white rounded mt-2" key={i}>
                                <div className="p-4">
                                    <div className="h-6 w-1/3 rounded-sm bg-gray-200 animate-pulse mb-4"></div>
                                    <div className="grid grid-cols-6 gap-1">
                                        <div className="col-span-3 h-5 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <br />
                                        <div className="col-span-1 row-start-2 h-5 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div className="col-span-1 row-start-2 h-5 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div className="col-span-1 row-start-2 h-5 rounded-sm bg-gray-200 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                        ))
                   }
                </div>
            }
            {
                (list.length !== 0 && !loading) &&
                <div className={`product-list-container ${gridType === 1 ? 'grid gap-4 xl:gap-x-8 grid-cols-1 md:grid-cols-2 xl:grid-cols-3  w-full mt-5' : 'mt-5'}`}>
                    {
                        sortedProducts.map((item, index) => (
                            <ProductItem data={item} type={gridType} key={index} showPricing={showPricing}/>
                        ))
                    }
                </div>
            }
        </>
    );
}

export default ProductList;
