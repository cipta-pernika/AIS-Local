<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CctvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Access any filters passed through the request if needed
        $terminalIds = $request->query('terminal_id', []);

        // Example: Conditional logic based on the terminal IDs
        $data = [
            'id' => $this->id,
            'url' => $this->url,
            'terminal_id' => $this->terminal_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Optionally modify the output based on the filters
        if (!empty($terminalIds) && !in_array($this->terminal_id, (array) $terminalIds)) {
            return []; // Skip returning this resource if it doesn't match the filter
        }

        return $data; // Return the transformed data
    }
}
