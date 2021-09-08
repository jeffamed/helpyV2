<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomField;
use App\Models\FieldsOption;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\TicketCustomField;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("customFields.index");
    }

    public function getCustomFieldData(Request $request)
    {
        $data = CustomField::query();

        return DataTables::of($data)
            ->addColumn('required', function($data){
                if($data->required == 1){
                    return "Yes";
                }else{
                    return "No";
                }
            })
            ->addColumn('status', function($data){
                if($data->status == 1){
                    return "Active";
                }else{
                    return "Inactive";
                }
            })
            ->addColumn('action', function ($data) {
                $optionRoute = route('CustomFieldOptions', $data->id);
                $option = '';
                if($data->type == 'select' || $data->type == 'radio'){
                    $option = '<a href="'.$optionRoute.'" class="btn btn-info btn-sm"><i class="fa fa-cog"></i> Options</a>';
                }else{
                    $option = '';
                }

                $value = '<button type="button" class="btn btn-primary btn-sm" id="getEditCustomFieldData" data-id="'.$data->id.'" title="Edit"><i class="fa fa-edit"></i></button>
                           <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteCustomFieldModal" class="btn btn-danger btn-sm" id="getDeleteId" title="Delete"><i class="la la-trash-o"></i></button>
                            '.$option;

                return $value;
            })
            ->rawColumns(['require','status','action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'type' => 'required'
        ]);

        $data = $request->all();
        $saved = CustomField::create($data);

        if ($saved) {
            $notify = storeNotify('Custom field created successully');
        }else{
            $notify = errorNotify('Custom field create');
        }

        return back()->with($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = CustomField::findOrFail($id);
        $html = view('customFields.modal-field', compact('field'))->render();

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name'     => 'required',
            'type'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $field = CustomField::find($id);
        $field->name = $request->name;
        $field->type = $request->type;
        $field->placeholder = $request->placeholder;
        $field->field_length = $request->field_length;
        $field->required = $request->required;
        $field->status = $request->status;
        $field->save();

        return response()->json(['success'=>'Custom field updated successfully']);
    }

    public function fieldOptions($id)
    {
        $field = CustomField::findOrFail($id);

        return view('customFields.fieldOptions', compact('field'));
    }

    public function fieldOptionsData(Request $request,$id)
    {
        $data = FieldsOption::where('field_id', $id);
        
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                // <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteOptionFieldModal" class="btn btn-danger btn-sm" id="getDeleteId" title="Delete"><i class="la la-trash-o"></i></button>
                $value = '<button type="button" class="btn btn-primary btn-sm" id="getEditOptionFieldData" data-id="'.$data->id.'" title="Edit"><i class="fa fa-edit"></i></button>
                           
                        ';

                return $value;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function storeOption(Request $request, $id)
    {
        $this->validate($request,[
            'value' => 'required'
        ]);

        $option = new FieldsOption();
        $option->value = $request->value;
        $option->field_id = $id;

        if ($option->save()) {
            $notify = storeNotify('Option saved successully');
        }else{
            $notify = errorNotify('Option create');
        }

        return back()->with($notify);
    }

    public function optionEdit($id)
    {
        $option = FieldsOption::findOrFail($id);
        $html = view('customFields.modal-field-option', compact('option'))->render();

        return response()->json(['html'=>$html]);
    }

    public function updateOption(Request $request, $id)
    {
        $this->validate($request,[
            'value' => 'required'
        ]);

        $option = FieldsOption::find($id);
        $option->value = $request->value;

        if ($option->save()) {
            $notify = storeNotify('Option updated successully');
        }else{
            $notify = errorNotify('Option update');
        }

        return back()->with($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customField = CustomField::find($id);

        $used = TicketCustomField::where('custom_field_id', $customField->id)->count();

        if($used == 0){
            $customField->delete();

            //$notify = deleteNotify('Knowledge base');
            return response()->json(['success'=>'Deleted successfully']);
            
        } else {
            return response()->json(['error'=>'This custom field is used, you can\'t delete this.']);
            //$notify = errorNotify("This department is used, you can't delete this.");
        }

        return redirect()->back()->with($notify);
    }
}

