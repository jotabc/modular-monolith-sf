import { Button } from "@chakra-ui/react";

export default function LoadMore({ loadMore }) {
  return (
    <Button variant='outline' colorScheme='blue' mt={3} size='md' onClick={loadMore}>
      Show More
    </Button>
  )
}