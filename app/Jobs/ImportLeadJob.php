<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\UniversalSearch;
use Illuminate\Support\Facades\DB;
use App\Traits\UniversalSearchTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportLeadJob implements ShouldQueue
{

    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, UniversalSearchTrait;

    private $row;
    private $columns;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row, $columns)
    {
        $this->row = $row;
        $this->columns = $columns;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!empty(array_keys($this->columns, 'name')) && !empty(array_keys($this->columns, 'mobile')) && isset($this->row[array_keys($this->columns, 'mobile')[0]])) {
            DB::beginTransaction();
            try {
                $lead = new Lead();
                $lead->name = $this->row[array_keys($this->columns, 'name')[0]];
                $lead->email = !empty(array_keys($this->columns, 'email')) ? $this->row[array_keys($this->columns, 'email')[0]] : null;
                $lead->notes = !empty(array_keys($this->columns, 'notes')) ? $this->row[array_keys($this->columns, 'notes')[0]] : null;
                $lead->phone_no = !empty(array_keys($this->columns, 'mobile')) ? $this->row[array_keys($this->columns, 'mobile')[0]] : null;
                $lead->save();
            

                DB::commit();

            return "Lead import successful!";

            } catch (\Exception $e) {
                DB::rollBack();
                  $this->fail($e); // Pass the exception instance
            }

        }
        else {
            $this->fail(__('messages.invalidData') . json_encode($this->row, true));
        }
    }

}

