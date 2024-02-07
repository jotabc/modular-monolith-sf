import {BsFillCalendar2WeekFill, BsPersonFill, BsTruck} from 'react-icons/bs'
import {FaFileContract} from 'react-icons/fa'

export const sideMenu = [
  { name: 'Dashboard', icon: BsFillCalendar2WeekFill, path: '/dashboard' },
  { name: 'Customers', icon: BsPersonFill, path: '/customers' },
  { name: 'Cars', icon: BsTruck, path: '/cars' },
  { name: 'Rentals', icon: FaFileContract, path: '/rentals' },
]
