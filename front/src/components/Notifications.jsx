import React, {useEffect, useState} from 'react';


const Notifications = ({found, notifications}) => {

    const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

  return (
    <div className='absolute top-[140%] left-[-155px] w-[250px]  bg-gray-100 p-3 rounded-md drop-shadow-md '>
        <p className='text-xl font-semibold text-[#054bb4]'>Notifications</p>
        <div className=' w-full divide-y-2 divide-gray-400'>

        {
            found ? (
                notifications.map((item, index) => {
                    const date = new Date(item['time_created'])
                    const day = weekday[date.getDay()].slice(0, 3)
                    let hour = date.getHours()
                    let m = ''
                    if(hour > 12){
                        hour = hour - 12
                        m = 'pm'
                    }
                    else{
                        m = 'am'
                    }
                    
                    return(
                    <div key={index} className='pt-4 px-1 text-base font-medium'>
                        <p>{item['body']}</p>
                        <div className='text-right'>
                            <span className='text-[12px] font-semibold text-gray-600'>{day} at {hour}:{date.getMinutes()}{m}</span>
                        </div>
                    </div>
                )})
            )
            :
            <div className='w-full text-center font-semibold text-gray-600 py-4'>
                <p>No New Notifications</p>
            </div>
        }
        </div>
    </div>
  )
}

export default Notifications