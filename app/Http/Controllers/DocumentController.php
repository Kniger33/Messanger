<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Document;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function index(int $userId, int $chatId)
    {
        $messages = Message::where('id_chat', '=', $chatId)->get();

        $docs = [];
        foreach ($messages as $message) {
            if (empty($message->attachmentsInfo[0])) continue;
            array_push($docs, $message->attachmentsInfo);
        }

        $data = $docs;
        return response($data, '200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $userId, int $chatId)
    {
        $newDocument = new Document();
        $newDocument->name = $request->name;
        $newDocument->date = $request->date;
        $newDocument->id_message = $request->message_id;
        $newDocument->link = "";
        $newDocument->save();

        $doc = Document::find(Document::max('id'));

        return response($doc,'201');
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId, int $chatId, int $documentId)
    {
        $document = Document::find($documentId);
        return response($document, '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $userId, int $chatId, int $documentId)
    {
        $document = Document::find($documentId);
        $document->name = $request->name;
        $document->date = $request->date;
        $document->save();

        return response($document, '200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $userId, int $chatId, int $documentId)
    {
        $doc = Document::find($documentId);
        $doc->delete();

        return response([
            'success' => 'success',
            'description' => 'Successfully deleted document'
        ], '200');
    }

    /**
     * Get document by id
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request, int $userId, int $chatId, int $documentId)
    {
        $doc = Document::find($documentId);
        return Storage::download($doc->link, $doc->name);
//        return Storage::download($doc->link, $doc->name.$doc->extendion);
    }

    /**
     * Add document
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function setData(Request $request, int $userId, int $chatId, int $documentId)
    {
        $link = '';

        $doc = Document::find($documentId);

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $link = $file->storeAs($chatId.'/'.$userId, $name);

            $doc->link = $link;
            $doc->name = $name;
            $doc->extension = $file->extension();
            $doc->save();

            return response($doc, '200');
        }
        else
        {
            return response([
                'success' => 'failed',
                'description' => 'There is no file'
            ], '404');
        }
    }

    /**
     * Get user`s docs in chat
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function userDocuments(int $userId, int $chatId)
    {
        $messages = Message::where('id_user', '=', $userId)
            ->where('id_chat', '=', $chatId)
            ->get();
        ;

        $docs = [];
        foreach ($messages as $message)
        {
            array_push($docs, $message->attachmentsInfo);
        }

        return response($docs, '200');
    }

}
