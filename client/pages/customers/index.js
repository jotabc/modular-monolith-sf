import {
  Box,
  Flex,
  FormControl,
  Heading,
  Icon, IconButton,
  Input,
  Table,
  TableContainer,
  Tbody,
  Td,
  Th,
  Thead,
  Tr
} from '@chakra-ui/react'
import { useSelector } from 'react-redux'
import { useCallback, useEffect, useState } from 'react'
import {FiChevronDown, FiChevronUp, FiPlus} from 'react-icons/fi'

import SidebarWithHeader from '../../src/components/sidebar/sidebar'
import { searchCustomers } from '../../src/service/api/customer/customer.service'
import InfinityScroll from '../../src/common/infinityScroll'
import {useRouter} from 'next/router'

export default function Customers() {
  const id = useSelector(state => state.auth.id)
  const router = useRouter()
  
  const [customers, setCustomers] = useState([])
  const [meta, setMeta] = useState({
    page: 1,
    limit: 10,
    hasNext: false,
    total: 0
  })
  const [filters, setFilters] = useState({
    name: '',
  })

  const [sorting, setSorting] = useState({
    sort: 'name',
    order: 'asc'
  })

  const buildFilters = useCallback((page, limit) => {
    let result = `?page=${page}&limit=${limit}&sort=${sorting.sort}&order=${sorting.order}`

    if ('' !== filters.name) {
      result += `&name=${filters.name}`
    }

    return result
  }, [filters, sorting])

  const search = useCallback(async (page = 1, limit = 30, loadMore = false) => {
    try {
      const response = await searchCustomers(id, buildFilters(page, limit))
      setCustomers(loadMore ? customers.concat(response.data.items) : response.data.items)
      setMeta(response.data.meta)

    } catch (e) {
      console.error({ e })
    }
  }, [id, customers, buildFilters])

  useEffect(() => {
    search()
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [filters, sorting])

  return (
    <SidebarWithHeader>
      <Heading>Customer List</Heading>
      <Flex display={{ md: 'flex' }} alignItems='center' justifyContent='space-between' mt={5} mb={5}>
        <Box>
          <FormControl>
            <Input
              name='name'
              size='lg'
              type='search'
              placeholder='Customer name...'
              onChange={(e) => {
                if ('' === e.target.value) {
                  setFilters(prevState => {
                    return {
                      ...prevState,
                      name: e.target.value
                    }
                  })
                }
              }}
              onKeyDown={(e) => {
                if (e.code === 'Enter') {
                  setFilters(prevState => {
                    return {
                      ...prevState,
                      name: e.target.value
                    }
                  })
                }
              }}
            />
          </FormControl>
        </Box>
        
        <Box mr="10">
          <IconButton
            size="lg"
            backgroundColor="cyan.400"
            aria-label="add customer"
            icon={<FiPlus color="white" />}
            onClick={() => router.push('/customers/add')}
          />
        </Box>
        
      </Flex>

      <TableContainer>
        <Table>
          <Thead>
            <Tr>
              <Th>ID</Th>
              <Th>
                Name
                <Icon
                  style={{ display: sorting.sort === 'name' ? 'inline' : 'none' }}
                  as={sorting.order === 'asc' ? FiChevronDown : FiChevronUp}
                  onClick={() => {
                    setSorting(prevState => {
                      return {
                        ...prevState,
                        sort: 'name',
                        order: 'asc' === prevState.order ? 'desc' : 'asc'
                      }
                    })
                  }}
                />
              </Th>
              <Th>Address</Th>
            </Tr>
          </Thead>

          <Tbody>
            {
              customers.map(customer => (
                <Tr key={customer.id}>
                  <Td>{customer.id}</Td>
                  <Td>{customer.name}</Td>
                  <Td>{customer.address}</Td>
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
