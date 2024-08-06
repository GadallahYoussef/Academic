import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { IoImage } from "react-icons/io5";
import { FaFilePdf } from "react-icons/fa6";
import { IoLogoYoutube } from "react-icons/io5";
import { FaFileAudio } from "react-icons/fa6";


const Materials = () => {
    const [materials, setMaterials] = useState([])
    const [found, setFound] = useState('')

    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_materials.php",{}, {withCredentials: true})
        .then((res) => (res.data))
        .then((res) => {
            setMaterials(res.materials)
            setFound(res.found)
        })
    }, [])

  return (
    <div className='container py-[70px]'>
        <div className='w-full flex justify-center mb-[20px]'>
            <h1 className='font-extrabold text-[60px] text-[#054bb4]'>Materials</h1>
        </div>
        <div className='grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 max-sm:px-10 gap-5'>
            {
                found ? 
                    (
                        materials && materials.map((item, index) => (
                            <a href={item.path} key={index} target='_blank'>
                            <div className='w-full h-[250px] bg-[#4a6b98] hover:bg-[#355076] rounded-md px-4 py-6 cursor-pointer flex flex-col items-center gap-6'>
                                <div className='h-1/3 flex items-center'>
                                {item.type == 'Image' && <IoImage size={90} className='text-white'/>}
                                {item.type == 'PDF' && <FaFilePdf size={80} className='text-white ml-2'/>}
                                {item.type == 'YouTube' && <IoLogoYoutube size={90} className='text-white'/>}
                                {item.type == 'Audio' && <FaFileAudio size={80} className='text-white'/>}
                                </div>
                                <p>{item.caption}</p>
                            </div>
                            </a>
                        ))
                    )
                 : 
                 <p> No materials yet</p>
                    
                
            }
        </div>
    </div>
  )
}

export default Materials