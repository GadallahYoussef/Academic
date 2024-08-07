import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { BsCalendarDateFill } from "react-icons/bs";

const Attendance = () => {

    const [found, setFound] = useState(false)
    const [attendance, setAttendance] = useState([])

    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_attendance.php", {}, { withCredentials: true })
            .then((res) => (res.data))
            .then((data) => {
                setAttendance(data.attendance)
                setFound(data.found)
            })

    }, [])

    return (
        <div className='max-md:hidden w-full md:w-[90%] md:absolute top-[50%]  flex flex-col gap-2 bg-[#658cc2] md:bg-opacity-80 rounded-md  p-4 z-50'>
            <div className='flex justify-center'>
            <p className=' text-3xl text-center font-bold bg-[#054bb4] text-white px-4 py-1 rounded-full '>Attendance</p>
            </div>
            <div className='w-full grid grid-cols-8'>
                {
                    found && attendance.map((item, index) => {
                        if (index == 0) {
                            return (
                                <div key={index} className='w-full grid grid-rows-3 items-center'>
                                    <div className='text-center'>
                                        <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'>{item[0]}</p>
                                    </div>
                                    <div className='w-full grid grid-cols-3 justify-center items-center gap'>
                                        <div ></div>
                                        <div className={`bg-white border-4 ${item[1] ? 'border-[#009E60]' : 'border-[#C70039]'} text-black w-[50px] h-[50px] text-[20px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none z-50`}>{index+1}</div>
                                        <div className='w-[50px] h-2 bg-[#054bb4] max-sm:ml-[22px]'></div>
                                    </div>
                                    <div className='text-center'>
                                        <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'></p>
                                    </div>
                                </div>
                            )
                        }
                        else {
                            if (index == 7) {
                                return (
                                    <div key={index} className='w-full grid grid-rows-3 items-center'>
                                        <div className='text-center'>
                                            <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'></p>
                                        </div>
                                        <div className='w-full grid grid-cols-3 justify-center items-center gap'>
                                            <div className='w-[50px] h-2 bg-[#054bb4] max-sm:ml-[22px]'></div>
                                            <div className={`bg-white border-4 ${item[1] ? 'border-[#009E60]' : 'border-[#C70039]'} text-black w-[50px] h-[50px] text-[20px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none z-50`}>{index+1}</div>
                                            <div></div>
                                        </div>
                                        <div className='text-center'>
                                            <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'>{item[0]}</p>
                                        </div>
                                    </div>
                                )
                            }
                            else {
                                return (
                                    <div key={index} className='w-full grid grid-rows-3 items-center'>
                                        <div className='text-center'>
                                            <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'>{index % 2 == 0 && item[0]}</p>
                                        </div>
                                        <div className='w-full grid grid-cols-3 justify-center items-center gap'>
                                            <div className='w-[50px] h-2 bg-[#054bb4] max-sm:ml-[22px]'></div>
                                            <div className={`bg-white border-4 ${item[1] ? 'border-[#009E60]' : 'border-[#C70039]'} text-black w-[50px] h-[50px] text-[20px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none z-50`}>{index+1}</div>
                                            <div className='w-[50px] h-2 bg-[#054bb4] max-sm:ml-[22px]'></div>
                                        </div>
                                        <div className='text-center'>
                                            <p className='font-bold flex-1 lg:text-[18px] md:text-[12px] text-white'>{index % 2 == 1 && item[0]}</p>
                                        </div>
                                    </div>
                                )
                            }
                        }

                    })
                }
            </div>
        </div>
    )
}

export default Attendance