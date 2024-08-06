import React, {useEffect} from 'react'
import axios from 'axios'

const Attendance = () => {


    useEffect(() => {
        const response = axios.post("http://localhost/academic/retrieve_attendance.php",{}, {withCredentials: true})
        .then((res) => (console.log(res)))

    }, [])

  return (
    <div>Attendance</div>
  )
}

export default Attendance