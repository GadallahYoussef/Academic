import React from 'react'
import image2 from '../assets/image-2.jpg'
import image5 from '../assets/image-5.jpg'
const Schedule = ({name, schedule}) => {
    return (
        <div className='w-full h-full flex'>
            <div className='w-3/5 flex flex-col justify-center pl-[70px] gap-7'>
            <h1 className='text-6xl font-bold '>Welcome, <span className=' text-[#054bb4]'>{name.split(' ')[0]}</span></h1>
            <div className='flex flex-col gap-3'>
                <p className='font-medium text-xl '>Your schedule</p>
                <div>
                    {
                        schedule.map((item, index) => (
                            <span>{item[0]} </span>
                        ))
                    }
                </div>
            </div>
            </div>
            <div className='w-2/5 '>
                <img src={image5} alt=""  className='w-full h-full'/>
            </div>
        </div>
    )
}

export default Schedule