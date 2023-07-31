<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getlocationtype()
    {
        $loctype = LocationType::all();

        return response()->json([
            'success' => true,
            'message' => $loctype,
        ], 200);
    }

    public function setlocation()
    {
        $loc = new LocationList;
        $loc->location_name = request('name');
        $loc->author = request('userId');
        $loc->location_type = request('typeloc');
        $loc->location_latitude = request('lat');
        $loc->location_longitude = request('long');
        $loc->save();

        $locnow = LocationList::join('location_type', 'location.location_type', 'location_type.id')
            ->where('location.id', $loc->id)
            ->select(
                'location.id',
                'location_type.icon',
                'location.author',
                'location_latitude',
                'location_longitude',
                'location_name',
                'location_type',
                'location_type_description',
                'location_type_name',
                'location.created_at',
                'location.updated_at'
            )->first();

        return response()->json([
            'success' => true,
            'message' => $locnow,
        ], 200);
    }

    public function getlocation()
    {
        $loc = LocationList::join('location_type', 'location.location_type', 'location_type.id')
            ->select('location_name', 'location.id', 'location_latitude', 'location_longitude', 'icon')
            ->where('location.author', request('id'))->orWhere('location.author', '1')->get();

        return response()->json([
            'success' => true,
            'message' => $loc,
        ], 200);
    }

    public function deletelocation()
    {
        $loc = LocationList::find(request('idLoc'));
        $loc->delete();

        return response()->json([
            'success' => true,
            'message' => $loc,
        ], 200);
    }
}
