import React from 'react'
import { GiHamburgerMenu } from "react-icons/gi";
import { HashLink } from 'react-router-hash-link';
import { BsFillCalendarDateFill } from "react-icons/bs";
import { ImBooks } from "react-icons/im";
import { FaTasks } from "react-icons/fa";
import { GiStopwatch } from "react-icons/gi";



const Menu = ({toggleMenu, setToggleMenu}) => {

    return (
        <div className={`sm:w-2/5 max-sm:w-4/6 max-sm:pl-5 pl-16 pt-2 h-screen fixed left-0 top-0 bg-gray-200 z-[60] md:hidden ${toggleMenu ? 'fixed' : 'hidden'}`}>
            <div className='flex flex-col gap-10'>
                <div className='flex items-center gap-5'>
                    <div className='md:hidden'>
                        <GiHamburgerMenu size={20} 
                        onClick={() => {
                            setToggleMenu(!toggleMenu)
                        }}
                        />
                    </div>
                    <h1 className='text-[#054bb4] font-extrabold text-[30px]'>Academia</h1>
                </div>
                <div className='flex flex-col  gap-6 pt-1 text-[#054bb4] mr-4'>
                    <HashLink smooth to={'#test1'}>
                    <div className='flex gap-6 items-center font-semibold w-full py-4 border-b-2 border-gray-400'>
                        <BsFillCalendarDateFill size={20} />
                        Schedule
                    </div>
                    </HashLink>
                    <HashLink smooth to={'#test2'}>
                    <div className='flex gap-6 items-center font-semibold w-full py-4 border-b-2 border-gray-400'>
                        <ImBooks size={20} />
                        Materials
                    </div>
                    </HashLink>
                    <HashLink smooth to={'#test3'}>
                    <div className='flex gap-6 items-center font-semibold w-full py-4 border-b-2 border-gray-400'>
                        <FaTasks size={20} />
                        Tasks
                    </div>
                    </HashLink>
                    <HashLink smooth to={'#test4'}>
                    <div className='flex gap-6 items-center font-semibold w-full py-4 border-b-2 border-gray-400'>
                        <GiStopwatch size={20} />
                        Quizes
                    </div>
                    </HashLink>
                </div>
            </div>
        </div>
    )
}

export default Menu