import React, {useEffect} from 'react'
import axios from 'axios';
import image2 from '../assets/image-2.jpg'
import image5 from '../assets/image-5.jpg'
import { BsCalendarDateFill } from "react-icons/bs";
import { VscDebugBreakpointLog } from "react-icons/vsc";


const Schedule = ({name, schedule, grade}) => {

    // useEffect(() => {
    //     const response = axios.post("http://localhost/academic/retrieve_attendence.php",{}, {withCredentials: true})
    //     .then((res) => (console.log(res)))

    // }, [])

    return (
        <div className='w-full h-full flex'>
            <div className='w-3/5 flex flex-col justify-center lg:pl-[70px] md: pl-[40px] gap-7'>
            <h1 className='lg:text-6xl md:text-5xl font-bold '>Welcome, <span className=' text-[#054bb4]'>{name.split(' ')[0]}</span></h1>
            <div className='flex flex-col gap-4'>
                <div className='flex items-center gap-4 bg-[#658cc2] text-white w-fit px-5 py-2 rounded-r-full' >
                    <BsCalendarDateFill size={23} className='text-white'/>
                    <p className='font-medium text-2xl '>Your schedule</p>
                </div>
                <div className='flex flex-col gap-3'>
                    {
                        schedule.map((item, index) => (
                            <div key={index} className='flex gap-3 items-center text-lg font-medium'>
                            <VscDebugBreakpointLog className='text-[#658cc2]' />
                            <p>{item[0]} {item[1]}PM - {item[2]}PM </p>
                            </div>
                        ))
                    }
                </div>
            </div>
            <div className='flex flex-col gap-4'>
                <div className='flex items-center gap-4 bg-[#658cc2] text-white w-fit px-5 py-2 rounded-r-full' >
                    <BsCalendarDateFill size={23} className='text-white'/>
                    <p className='font-medium text-2xl '>Your schedule</p>
                </div>
                <div className='flex flex-col gap-3'>
                    {
                        schedule.map((item, index) => (
                            <div key={index} className='flex gap-3 items-center text-lg font-medium'>
                            <VscDebugBreakpointLog className='text-[#658cc2]' />
                            <p>{item[0]} {item[1]}PM - {item[2]}PM </p>
                            </div>
                        ))
                    }
                </div>
            </div>

            </div>
            <div className='w-2/5 relative'>
                <img src={image5} alt=""  className='w-full landingImage'/>
                <div className='absolute bg-[#054bb4] w-[60px] h-[250px] top-0 left-[-30px] rounded-b-full text-white'>
                </div>
                    <div className='-rotate-90 w-[150px] h-[100px] absolute top-14 -left-12'>
                        <p className='font-bold text-4xl text-white'>Grade {grade}</p>
                    </div>
            </div>
        </div>
    )
}

export default Schedule