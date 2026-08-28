<!-- Use Package -->
barryvdh/laravel-dompdf ....................................................................................... DONE
laravel/pail .................................................................................................. DONE
laravel/sail .................................................................................................. DONE
laravel/tinker ................................................................................................ DONE
livewire/livewire ............................................................................................. DONE
nesbot/carbon ................................................................................................. DONE
nunomaduro/collision .......................................................................................... DONE
nunomaduro/termwind ........................................................................................... DONE
php-flasher/flasher-laravel ................................................................................... DONE
php-flasher/flasher-toastr-laravel ............................................................................ DONE
yajra/laravel-datatables-buttons .............................................................................. DONE
yajra/laravel-datatables-editor ............................................................................... DONE
yajra/laravel-datatables-export ............................................................................... DONE
yajra/laravel-datatables-fractal .............................................................................. DONE
yajra/laravel-datatables-html ................................................................................. DONE
yajra/laravel-datatables-oracle ............................................................................... DONE

<!-- Use DOMPDF -->
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('pdf.invoice', $data);
return $pdf->download('invoice.pdf');

<!-- Server Datatable -->
if ($request->ajax()) {
    $data = Model::select('*');
    return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
}
