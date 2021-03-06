<?php
namespace EQM\Models\Advertising\Advertisements;

interface AdvertisementRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    public function update(Advertisement $advertisement, array $values);
    
    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     */
    public function delete(Advertisement $advertisement);
    
    /**
     * @param int $id
     * @return \EQM\Models\Advertising\Advertisements\Advertisement|null
     */
    public function findById($id);

    /**
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function findAll();
    
    public function findAllPaginated($limit = 10);

    /**
     * @param string $type
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function findRandomByType($type);

    /**
     * @return int
     */
    public function count();
}
