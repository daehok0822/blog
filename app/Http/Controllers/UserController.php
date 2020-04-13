<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.user', compact('users'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->input('name'))){
            return response()->json([
                'result' => '실패',
            ]);
        }
        if(empty($request->input('email'))){
            return response()->json([
                'result' => '실패',
            ]);
        }
        if(empty($request->input('password'))){
            return response()->json([
                'result' => '실패',
            ]);
        }

        $userInfo =[
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'isAdmin' => true
        ];
        $user = User::create($userInfo);
        return response()->json([
            'result' => '생성되었습니다',
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::find($id);
        if(empty($request->input('name'))){
            return response()->json([
                'result' => '실패',
            ]);
        }
        if(empty($request->input('email'))){
            return response()->json([
                'result' => '실패',
            ]);
        }
        if(!empty($request->input('password'))){
            $user->password = Hash::make($request->input('password')) ;
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');


        $user->update();
        return response()->json([
            'id' => $id,
            'result' => '변경되었습니다',

        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'id' => $id
        ]);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', '이름');
        $sheet->setCellValue('B1', '이메일');
        $sheet->setCellValue('C1', '가입일');
        $writer = new Xlsx($spreadsheet);
        $users = User::all();
        foreach ($users as $key => $user)
        {
            $key = $key + 2;
            $sheet->setCellValue('A' . $key, $user->name);
            $sheet->setCellValue('B' . $key, $user->email);
            $sheet->setCellValue('C' . $key, $user->created_at);
        }
        //$writer->save('hello_world.xlsx');

        $filename = 'member_' . date("Y-m-d");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');

        $writer->save('php://output');
    }
}
