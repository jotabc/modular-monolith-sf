
import {Heading, Table, TableContainer, Tbody, Td, Th, Thead, Tr} from '@chakra-ui/react'
import SidebarWithHeader from '../../src/components/sidebar/sidebar'
import {useSelector} from 'react-redux'
import {searchCustomers} from '../../src/service/api/customer/customer.service'
import {useCallback, useEffect, useState} from 'react'
import InfinityScroll from '../../src/common/infinityScroll'

export default function Customers() {
  const id = useSelector( state => state.auth.id)
  const [customers, setCustomers] = useState([])
  const [meta, setMeta] = useState({
    page: 1,
    limit: 10,
    hasNext: false,
    total: 0
  })

  const buildFilters = useCallback( (page, limit) => {
    return `?page=${page}&limit=${limit}`
  }, [])
  
  const search = useCallback(async (page = 1, limit = 30, loadMore = false) => {
    try {
      const response = await searchCustomers(id, buildFilters(page, limit))
      setCustomers(loadMore ? customers.concat(response.data.items) : response.data.items)
      setMeta(response.data.meta)
      
    } catch (e) {
      console.error({ e })
    }
  }, [id, customers])
  
  useEffect(() => {
    search()
      .then()
  }, [])
  
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
                <Tr key={ customer.id }>
                  <Td>{ customer.id }</Td>
                  <Td>{ customer.name }</Td>
                  <Td>{ customer.address }</Td>
                </Tr>
              ))
            }
          </Tbody>
        </Table>
      </TableContainer>
      <InfinityScroll meta={meta} collection={customers} search={search} />
    </SidebarWithHeader>
  )
}
