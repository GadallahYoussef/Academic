import React, {useEffect, useState} from 'react'
import axios from 'axios'
import image6 from '../assets/image-6.jpg'
import { VscDebugBreakpointLog } from "react-icons/vsc";


const Tasks = () => {

    const [tasks, setTasks] = useState([])
    const [found, setFound] = useState(false)
    
    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_tasks.php",{}, {withCredentials: true})
        .then((res) => (res.data))
        .then((data) => {
            setFound(data.found)
            setTasks(data.tasks)
        })

    }, [])

  return (
    <div className='w-full h-screen '>
        <div className='flex'>
            <div className='w-2/5'>
                <img src={image6} alt="" className='w-full h-screen  object-cover'/>
            </div>
            <div className='w-3/5 pl-[40px] pt-[60px] flex flex-col gap-8'>
                <p className='font-extrabold text-[60px] text-[#054bb4]'>Tasks</p>
                <div className='flex flex-col gap-4'>
                    {
                        found && tasks.map((item) => (
                            <div className='flex flex-col'>
                                <div className='flex gap-3 text-2xl items-center'>
                                    <VscDebugBreakpointLog className='text-[#054bb4]' />
                                    <span>{item.category}</span>
                                </div>
                                <p>{item.task}</p>
                            </div>
                        ))
                    }
                </div>
            </div>
        </div>
    </div>
  )
}

export default Tasks