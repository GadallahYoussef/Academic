import { useEffect, useState } from 'react'
import {Routes, Route, useNavigate} from 'react-router-dom'
import LoginPage from './pages/LoginPage'
import StudentDashboard from './pages/StudentDashboard'

function App() {
  
  // const navigate = useNavigate();
  // useEffect(() => {
  //   navigate('/login')
  // },[])

  return (
    <>
    <Routes>
      <Route path='/login' element={<LoginPage/>}/>
      <Route path='/student' element={<StudentDashboard/>}/>

    </Routes>
     
    </>
  )
}

export default App
