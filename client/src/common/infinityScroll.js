import { Center, Text } from '@chakra-ui/react' 
import LoadMore from '../components/table/load-more'

export default function InfinityScroll({ meta, collection, search }) {
  return meta.hasNext ? (
    <>
      <Center>
        <LoadMore loadMore={() => search( meta.page + 1, meta.limit, true)} />
      </Center>
      <Text mt={5} align={'center'}>
        Showing {collection.length} of {meta.total} results
      </Text>
    </>
  ) : (
    <Text mt={3} align={'center'}>
      Showing {collection.length} of {meta.total} results
    </Text>
  )
}