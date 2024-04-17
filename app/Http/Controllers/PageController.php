<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function abouts(Page $abouts)
	{
		$data['title'] = 'About Us';
		$data['aboutData'] = $abouts->getPages('about-us');
		return view('pages.abouts', $data);
	}

	public function abouts_store(Request $request, Page $abouts)
	{

		$request->validate([
			'title' => 'required',
			'description' => 'required',
		]);
		$inputArr = $request->except(['_token']);


		$inputArr['slug'] = 'about-us';

		$arrayData = $abouts->getPages("about-us");
		if (!empty ($arrayData)) {
			$abouts->updatePage($arrayData->id, $inputArr);
			return redirect()->route('admin.abouts.index')->with('success', 'Your about-us  details updated successfully.');
		} else {
			$abouts->savePage($inputArr);
			return redirect()->route('admin.abouts.index')->with('success', 'Your about-us create successfully.');
		}

	}

	public function privacy(Page $abouts)
	{
		$data['title'] = 'Privacy Policy | DealTalk';
		$data['privacyData'] = $abouts->getPages('privacy-policy');
		return view('pages.privacy_policy', $data);
	}

	public function privacy_store(Request $request, Page $abouts)
	{

		$request->validate([
			'title' => 'required',
			'description' => 'required',
		]);
		$inputArr = $request->except(['_token']);

		$inputArr['slug'] = 'privacy-policy';

		$arrayData = $abouts->getPages("privacy-policy");
		if (!empty ($arrayData)) {
			$abouts->updatePage($arrayData->id, $inputArr);
			return redirect()->route('admin.privacy.index')->with('success', 'Your privacy policy  details updated successfully.');
		} else {
			$abouts->savePage($inputArr);
			return redirect()->route('admin.privacy.index')->with('success', 'Your privacy policy create successfully.');
		}

	}
    public function term_condition(Page $abouts)
	{
		$data['title'] = 'Terms & Conditions  | DealTalk';
		$data['termData'] = $abouts->getPages('terms-condition');
		return view('pages.term_condition', $data);
	}
    public function term_condition_store(Request $request, Page $abouts)
	{

		$request->validate([
			'title' => 'required',
			'description' => 'required',
		]);
		$inputArr = $request->except(['_token']);


		$arrayData = $abouts->getPages("terms-condition");
		$inputArr['slug'] = 'terms-condition';
		if (!empty ($arrayData)) {
			$abouts->updatePage($arrayData->id, $inputArr);
			return redirect()->route('admin.term.index')->with('success', 'Your term condition details updated successfully.');
		} else {
			$abouts->savePage($inputArr);
			return redirect()->route('admin.term.index')->with('success', 'Your term condition create successfully.');
		}

	}
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
    
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
    
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
    
            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
    
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore); 
            $msg = 'Image successfully uploaded'; 
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            
            // Render HTML output 
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }   
}
