
import {Heading, Table, TableContainer, Tbody, Td, Th, Thead, Tr} from '@chakra-ui/react'
import SidebarWithHeader from '../../src/components/sidebar/sidebar'
import {useSelector} from 'react-redux'
import {searchCustomers} from '../../src/service/api/customer/customer.service'
import {useCallback, useEffect, useState} from 'react'

export default function Customers() {
  const id = useSelector( state => state.auth.id)
  const [customers, setCustomers] = useState([{ id: '1', name:'Juan', address: 'Address 1'}])
  
  const search = useCallback(async () => {
    try {
      const response = await searchCustomers(id, '?page=1&limit=10')
      console.log(response.data)
      
    } catch (e) {
      console.error({ e })
    }
  }, [id])
  
  useEffect(() => {
    search()
      .then()
  }, [customers, search])
  
  return (
    <SidebarWithHeader>
      <Heading>Welcome to the Customers</Heading>
      <TableContainer>
        <Table>
          <Thead>
            <Tr>
              <Th>ID</Th>
              <Th>Name</Th>
              <Th>Address</Th>
            </Tr>
          </Thead>
          
          <Tbody>
            {
              customers.map( customer => (
                <Tr key={customer.id}>
                  <Td>{ customer.id }</Td>
                  <Td>{ customer.name }</Td>
                  <Td>{ customer.address }</Td>
                </Tr>
              ))
            }
          </Tbody>
        </Table>
      </TableContainer>
    </SidebarWithHeader>
  )
}
