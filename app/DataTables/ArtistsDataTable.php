<?php

namespace App\DataTables;

use App\Models\Artist;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ArtistsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
       return datatables()
            ->eloquent($query)
            ->addColumn('action', function($row){ // ? Header
       
               $btn = '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#artistModal"  data-id="'.$row->id.'"  > Edit</button>';
                return $btn;
              });
                     // ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Artist $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Artist $model)
    {   // ? pwede where or orderby pag nakita newQuery
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('artists-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create')->addClass('btn btn-sm'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ); // TODO: Incase walang lumalabas kulang ka ng gento php artisan vendor:publish --tag=datatables-buttons and php artisan vendor:publish --tag=datatables
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
         return [
            
            Column::make('id'),
            Column::make('artist_name')->title('artist'), // ? Title is yung header
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('action') // ! kailagan imanu mano sa pag gawa button need to specify title pag di binago action yung name
                  ->exportable(false)
                  ->printable(false)
                  
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Artists_' . date('YmdHis');
    }
}
