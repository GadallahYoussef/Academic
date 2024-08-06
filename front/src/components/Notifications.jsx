import React, {useEffect, useState} from 'react';
import axios from 'axios';
const Notifications = () => {

    const [found, setFound] = useState(false)
    const [notifications, setNotifications] = useState([])

    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_notification.php",{}, {withCredentials: true})
        .then((res) => (res.data))
        .then((data) => {
            setFound(data.found)
            setNotifications(data.notification)
        })
    }, [])

  return (
    <div className='absolute top-[140%] left-[-155px] w-[250px]  bg-gray-100 p-3 rounded-md drop-shadow-md '>
        <p className='text-xl font-semibold text-[#054bb4]'>Notifications</p>
        <div className=' w-full divide-y-2 divide-gray-400'>

        {
            found ? (
                notifications.map((item) => (
                    <div className='py-4 px-1 text-md'>
                        {item['body']}
                    </div>
                ))
            )
            :
            <p>No New Notifications</p>
        }
        </div>
    </div>
  )
}

export default Notifications