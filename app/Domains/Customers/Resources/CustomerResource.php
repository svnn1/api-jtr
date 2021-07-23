<?php

namespace App\Domains\Customers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ContactsFromCustomerResource
 *
 * @package App\Domains\Customers\Resources
 */
class CustomerResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array
   */
  public function toArray($request): array
  {
    return [
      "id"              => $this->id,
      "document_number" => $this->document_number,
      "email"           => $this->email,
      "name"            => $this->name,
      "website"         => $this->website,
      "contacts"        => $this->whenLoaded('contacts'),
      "locations"       => $this->whenLoaded('locations'),
    ];
  }
}
