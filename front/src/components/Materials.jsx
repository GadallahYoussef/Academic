import React, { useEffect } from 'react'
import axios from 'axios'

const Materials = () => {
    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_materials.php",{}, {withCredentials: true})
        .then((res) => console.log(res))
    }, [])

  return (
    <div className='container pt-[70px]'>
        <div className='w-full flex justify-center mb-[20px]'>
            <h1 className='font-extrabold text-[60px] text-white'>Materials</h1>
        </div>
        
    </div>
  )
}

export default Materials