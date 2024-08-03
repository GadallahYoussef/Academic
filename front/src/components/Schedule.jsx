import React from 'react'
import image2 from '../assets/image-2.jpg'
import image3 from '../assets/image-3.jpg'
const Schedule = () => {
    return (
        <div className='w-full h-full flex px-4'>
            <div className='w-2/3 h-full flex flex-col justify-center gap-10  max-lg:w-full max-lg:justify-start max-lg:mt-[30px] md:justify-center'>
                <span class="before:w-[240px] before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-[#054bb4] relative inline-block">
                    <span class="relative text-white font-bold text-[40px] pl-4">July, 2024</span>
                </span>
                <div>
                    <div className='flex gap-6 items-center'>
                        <div className='bg-white border-4 border-[#009E60] text-black w-[70px] h-[70px] text-[36px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none'>1</div>
                        <p className='font-semibold flex-1 text-[20px]'>Saturday, 7-6-2024, 7:00 pm</p>
                    </div>
                    <div className='w-[6px] h-10 ml-[32px] bg-[#054bb4] max-sm:ml-[22px]'></div>
                    <div className='flex gap-6 items-center'>
                        <div className='bg-white border-4 border-[#009E60] text-black w-[70px] h-[70px] text-[36px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none'>2</div>
                        <p className='font-semibold flex-1 text-[20px]'>Saturday, 14-6-2024, 7:00 pm</p>
                    </div>
                    <div className='w-[6px] h-10 ml-[32px] bg-[#054bb4] max-sm:ml-[22px]'></div>
                    <div className='flex gap-6 items-center'>
                        <div className='bg-white border-4 border-[#C70039] text-black w-[70px] h-[70px] text-[36px] flex items-center justify-center rounded-full max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none'>3</div>
                        <p className='font-semibold flex-1 text-[20px]'>Saturday, 21-6-2024, 7:00 pm</p>
                    </div>
                    <div className='w-[6px] h-10 ml-[32px] bg-[#054bb4] max-sm:ml-[22px]'></div>
                    <div className='flex gap-6 items-center'>
                        <div className='bg-white w-[70px] h-[70px] text-[36px] flex items-center justify-center rounded-full border-4 border-[#054bb4] max-sm:w-[50px] max-sm:h-[50px] max-sm:text-[26px] select-none'>4</div>
                        <p className='font-semibold flex-1 text-[20px]'>Saturday, 28-6-2024, 7:00 pm</p>
                    </div>
                </div>
            </div>
            <div className='w-1/2 h-full relative flex items-center mr-[20px] max-lg:hidden'>
                <div className='before:w-full before:h-[365px] before:left-[-10%] before:bottom-[20%] before:z-0 before:border-4 before:border-[#054bb4] before:absolute'></div>
                <div className='before:w-full before:h-[365px] before:right-[-10%] before:top-[20%] before:z-0 before:border-4 before:border-[#054bb4] before:absolute'></div>
                <img src={image3} alt="" className='w-full z-50' />
            </div>
            <div className='w-1/2 h-full relative items-center mr-[20px] lg:hidden md:flex max-md:hidden'>
                <div className='before:w-full before:h-[365px] before:left-[-10%] before:bottom-[20%] before:z-0 before:border-4 before:border-[#054bb4] before:absolute'></div>
                <div className='before:w-full before:h-[365px] before:right-[-10%] before:top-[20%] before:z-0 before:border-4 before:border-[#054bb4] before:absolute'></div>
                <img src={image2} alt="" className='w-full z-50' />
            </div>
        </div>
    )
}

export default Schedule