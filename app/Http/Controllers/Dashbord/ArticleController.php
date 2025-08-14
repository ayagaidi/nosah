<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        ActivityLogger::activity('عرض جميع المقالات');
        return view('dashbord.articles.index');
    }

    public function articles()
    {
        $articles = Articles::with('users')->orderBy('created_at', 'DESC');
        return datatables()->of($articles)
            ->addColumn('edit', function ($article) {
                $article_id = encrypt($article->id);
                return '<a style="color: #f97424;" href="' . route('articles/edit', $article_id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('delete', function ($article) {
                $article_id = encrypt($article->id);
                return '<a href="' . route('articles/delete', $article_id) . '"><i class="fa fa-trash"></i></a>';
            })
            ->addColumn('status', function ($article) {
                // show text status
                return $article->published ? 'منشور' : 'غير منشور';
            })
               ->addColumn('image', function ($article) {
                return $article->bkimage
                    ? '<img src="' . asset('images/articles/'.$article->bkimage) . '" alt="صورة الحمية" style="max-width:80px;">'
                    : 'لا يوجد';
            })
            ->addColumn('published', function ($article) {
                $article_id  = encrypt($article->id);
                $btnClass    = $article->published ? 'btn-success' : 'btn-secondary';
                $btnText     = $article->published ? 'إلغاء نشر'    : 'نشر';
                $toggleText  = $article->published ? 'إلغاء نشر'    : 'نشر';
                $icon        = $article->published 
                               ? '<i class="fa fa-eye"></i>' 
                               : '<i class="fa fa-eye-slash"></i>';
                return '<button class="btn btn-sm '.$btnClass.' toggle-publish"'
                     . ' data-id="'.$article_id.'"'
                     . ' data-published="'.$article->published.'"'
                     . ' data-toggle="tooltip" title="'.$btnText.'">'
                     . $icon.' '.$toggleText
                     . '</button>';
            })
            ->rawColumns(['edit', 'delete','image', 'published'])
            ->make(true);
    }

    public function create()
    {
        ActivityLogger::activity('عرض صفحة إنشاء مقال جديد');
        return view('dashbord.articles.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'عنوان المقال مطلوب.',
            'content.required' => 'محتوى المقال مطلوب.',
        ];
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate image
        ], $messages);

        try {
            DB::transaction(function () use ($request) {
                $article = new Articles();
                $article->title = $request->title;
                $article->content = $request->content;
                $article->users_id = auth()->user()->id;

                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "article_" . time() . ".jpg";
                    $fileObject->move('images/articles/', $image);
                    $article->bkimage = $image;
                }

                $article->save();
            });

            Alert::success('تمت إضافة المقال بنجاح.');
            ActivityLogger::activity($request->title . ' تمت إضافته بنجاح إلى المقالات.');

            return redirect()->route('articles');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->title . ' فشل في الإضافة إلى المقالات.');

            return redirect()->route('articles');
        }
    }

    public function edit($article)
    {
        $article_id = decrypt($article);
        $article = Articles::find($article_id);
        ActivityLogger::activity('عرض صفحة تعديل المقال');
        return view('dashbord.articles.edit', compact('article'));
    }

    public function update(Request $request, $article)
    {
        $article_id = decrypt($article);

        $messages = [
            'title.required' => 'عنوان المقال مطلوب.',
            'content.required' => 'محتوى المقال مطلوب.',
        ];
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate image
        ], $messages);

        try {
            DB::transaction(function () use ($request, $article_id) {
                $article = Articles::find($article_id);
                $article->title = $request->title;
                $article->content = $request->content;

                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "article_" . time() . ".jpg";
                    $fileObject->move('images/articles/', $image);
                    $article->bkimage = $image;
                }

                $article->save();
                ActivityLogger::activity($article->title . ' تم تعديل المقال بنجاح.');
            });

            Alert::success('تم تعديل المقال بنجاح');
            return redirect()->route('articles');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->title . ' فشل تعديل المقال.');

            return redirect()->route('articles');
        }
    }

    public function delete($article)
    {
        $article_id = decrypt($article);
        $article = Articles::find($article_id);

        try {
            DB::transaction(function () use ($article) {
                $article->delete();
            });

            ActivityLogger::activity($article->title . ' تم حذف المقال بنجاح.');
            Alert::success('تم حذف المقال بنجاح.');

            return redirect()->route('articles');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($article->title . ' فشل في حذف المقال.');

            return redirect()->route('articles');
        }
    }

    public function togglePublish(Request $request)
    {
        $article_id = decrypt($request->id);
        $article = Articles::findOrFail($article_id);
        $article->published = !$article->published;
        $article->save();

        ActivityLogger::activity(($article->published ? 'تم نشر' : 'تم إلغاء نشر') . ' المقال: ' . $article->title);

        return response()->json([
            'success' => true,
            'published' => $article->published,
            'message' => $article->published ? 'تم نشر المقال' : 'تم إلغاء نشر المقال'
        ]);
    }
}
