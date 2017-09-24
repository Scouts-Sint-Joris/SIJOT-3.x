<?php

namespace Sijot\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Sijot\Lease;

/**
 * Class LeaseTransformer
 * 
 * @category Sijot_Platform_Api.
 * @package  Sijot\Http\Transformers
 * @author   Tim Joosten <Topairy@gmail.com>
 * @license  MIT LICENSE
 * @link     http://www.st-joris-turnhout.be
 */
class LeaseTransformer extends TransformerAbstract
{
    /**
     * The transformer for the lease section of the API. 
     * 
     * @param Lease $lease The lease database model.
     * 
     * @return array
     */
    public function transform(Lease $lease)
    {
        // TODO: Implement the lease status in the lease transformer. 
        
        return [
            'id'     => $lease->id,
            'requester' => [
                'email_adres' => $lease->contact_email,
                'tel_nummer'  => $lease->tel_nummer,
                'groeps_naam' => $lease->groeps_naam
            ],
            'periode' => [
                'start_datum' => strtotime($lease->start_datum),
                'eind_datum'  => strtotime($lease->eind_datum),
            ],
            'lokalen' => [
                // The lokalen output comes with standarized output characters. 
                // ----
                //! N = NO      (The building is not included in the lease)
                //! Y = YES     (The building is included in the lease)
                //! U = UNKNOWN (Unknown indication for the building)

                'kapoenen'      => is_null($lease->kapoenen_lokaal)   ? 'U' : $lease->kapoenen_lokaal,
                'welpen'        => is_null($lease->welpen_lokaal)     ? 'U' : $lease->welpen_lokaal, 
                'jong_givers'   => is_null($lease->jongGivers_lokaal) ? 'U' : $lease->jongGivers_lokaal,
                'givers'        => is_null($lease->givers_lokaal)     ? 'U' : $lease->givers_lokaal,
                'jins_lokaal'   => is_null($lease->jins_lokaal)       ? 'U' : $lease->jins_lokaal,
                'grote_zaal'    => is_null($lease->grote_zaal)        ? 'U' : $lease->grote_zaal,
                'toiletten'     => is_null($lease->toiletten)         ? 'U' : $lease->toiletten,
            ],
        ];
    }
}