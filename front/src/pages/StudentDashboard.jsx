import React from 'react'
import Navbar from '../components/Navbar';
import Menu from '../components/Menu';
import { useState } from 'react';
import Schedule from '../components/Schedule';


const StudentDashboard = () => {

    const [toggleMenu, setToggleMenu] = useState(false)

    return (
        <div className='w-full flex justify-center'>
            <Menu toggleMenu={toggleMenu} setToggleMenu={setToggleMenu} />
            <div className='container '>
                <div className='fixed container z-50'>
                    <Navbar toggleMenu={toggleMenu} setToggleMenu={setToggleMenu} />
                </div>
                <div id='test1' className='pt-[60px] h-dvh mb-[200px]'>
                    <Schedule/>
                </div>
                <div id='test2'>
                    dfgd
                </div>
                <div id='test3'>
                    dfgd
                </div>
                <div id='test4'>
                    dfgd
                </div>
            </div>
        </div>
    )
}

export default StudentDashboard