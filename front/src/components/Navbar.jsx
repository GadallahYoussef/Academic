import React from 'react'
import { LuLogOut } from "react-icons/lu";
import { IoMdNotificationsOutline } from "react-icons/io";
import { GiHamburgerMenu } from "react-icons/gi";
import { HashLink } from 'react-router-hash-link';

const Navbar = ({toggleMenu, setToggleMenu}) => {

    return (
        <div className='h-[60px] flex items-center p-4 justify-between bg-white'>
            <div className='flex gap-10 items-center'>
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
                <div className='flex items-center gap-10  pt-1 max-md:hidden font-medium'>
                    <HashLink smooth to={'#test1'}>Schedule</HashLink>
                    <HashLink smooth to={'#test2'}>Materials</HashLink>
                    <HashLink smooth to={'#test3'}>Tasks</HashLink>
                    <HashLink smooth to={'#test4'}>Quizes</HashLink>
                </div>
            </div>
            <div className='flex gap-3  items-center'>
                <IoMdNotificationsOutline size={24} className='cursor-pointer' />
                <button className='bg-[#658cc2] ml-5 max-md:ml-1 py-1 px-3 rounded-md text-white flex gap-2 items-center'>
                    <LuLogOut />
                    <span className='max-sm:hidden'>Logout</span>
                </button>
            </div>
        </div>
    )
}

export default Navbar