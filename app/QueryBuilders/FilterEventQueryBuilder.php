<?php

namespace App\QueryBuilders;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class FilterEventQueryBuilder
{
    protected Builder $query;
    protected $perPage = 10;
    protected $page;

    public function __construct()
    {
        $this->query = Event::query();
    }

    public function setPagination(int $page, int $perPage): self
    {
        $this->page = $page;
        $this->perPage = $perPage;
        return $this;
    }

    public function setDateRange($fromDate = null, $toDate = null): self
    {
        if (is_null($toDate)) {
            $toDate = Carbon::now();
        }

        if ($fromDate && $toDate) {
            $this->query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $this->query->where('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $this->query->where('created_at', '<=', $toDate);
        } else {
            $toDate = Carbon::now();
            $this->query->where('created_at', '<=', $toDate);
        }

        return $this;
    }

    public function organizedBy($userId): self
    {
        if ($userId) {
            $this->query->where('organizer_id', $userId);
        }
        return $this;
    }


    public function setCity($city): self
    {
        if ($city) {
            $this->query->where('city', $city);
        }
        return $this;
    }
    public function setStatus($status): self
    {
        if ($status) {
            $this->query->where('status', $status);
        }
        return $this;
    }



    public function build()
    {
        return $this->query->select([
            'title',
            'description',
            'image_url',
            'start_datetime',
            'end_datetime',
            'venue',
            'city',
            'state',
            'country',
            'organizer_id',
            'status',
            'is_active',
            
                    ])->orderBy("created_at","desc");
    }

    public function paginate(): LengthAwarePaginator
    {
        return $this->build()->paginate($this->perPage, ['*'], 'page', $this->page);
    }
}
