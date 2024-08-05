import React, { useEffect } from 'react'
import Navbar from '../components/Navbar';
import Menu from '../components/Menu';
import { useState } from 'react';
import Schedule from '../components/Schedule';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';


const StudentDashboard = () => {

    const [toggleMenu, setToggleMenu] = useState(false)
    const [name, setName] = useState('')
    const [grade, setGrade] = useState('')
    const [schedule, setSchedule] = useState([])
    const navigate = useNavigate()

    useEffect(()=>{
        const response = axios.post("http://localhost/academic/index.php",{}, {withCredentials: true})
        .then((res) => {
            console.log(res)
            if(res.data.authenticated == false){
                navigate('/login')
            }
            else{
                setName(res.data['student_name'])
                setGrade(res.data['student_grade'])
                setSchedule(res.data['schedule'])
                console.log([res.data['schedule']])
            }
        })
    }, [])

    const handleLogOut = () => {
        // const response = axios.post("http://localhost/academic/logout.php")
    }

    return (
        <div className='w-screen flex justify-center '>
            <Menu toggleMenu={toggleMenu} setToggleMenu={setToggleMenu} />
            <div className='flex flex-col items-center'>
                <div className='fixed w-full z-50  bg-white '>
                    <Navbar toggleMenu={toggleMenu} setToggleMenu={setToggleMenu} handleLogOut={handleLogOut}/>
                </div>
                <div id='test1' className='h-screen bg-white'>
                    <div className='w-screen h-[60px] bg-white'></div>
                    <Schedule name={name} schedule={schedule} grade={grade}/>
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