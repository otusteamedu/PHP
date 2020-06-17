Один из старых проектов был класс PostController в laravel в методе слишком много выполнялось и решил переделать по принципу единственной ответсвенности
```php
class PostController extends Controller
{
    public function update($post_id, Request $request)
    {
        $post = Post::find($post_id);
        if (!$post) {
            abort(404);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
             'text' => 'required|string',
             'is_active' => 'required|integer'
        ]);
        
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        
        $post->update($request->all());
        
        foreach ($post->authors as $author) {
            $words_count = 0;
            foreach ($author->posts as $posts) {
                $words_count += str_word_count($posts->text);
            }
            $author->words_count = $words_count;
            $author->save();
        }
        
        $admin = User::where('role', 'admin')->first();
        
        if($admin) {
            Mail::send('emails.post_updated', ['post' => $post], function ($m) use ($admin) {
                    $m->from('admin@admin.ru', 'Application');
                    $m->to($admin->email, $admin->name)->subject('Post updated!');
            });
        }
        return redirect()->route('admin.posts.index');      
    }
}
```


Вынес отдельно проверку на валидацию, также добавил observer для слежения, когда пост обновляется.
Добавил также отдельный класс для уведомлений и отдельный класс Job;
И теперь каждый отдельный класс выполняет свою задачу.
```php
class PostUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
             'title' => 'required|string|max:255',
            'text' => 'required|string',
            'is_active' => 'required|integer'
        ];
    }
}

class PostObserver
{
    public function updated(Post $post, PostService $postService)
    {
         foreach ($post->authors as $author) {
             $author->wordsCount = $postService->calculateAuthorWords($author);
             $author->save();
         }
        dispatch(new SendPostUpdatedJob($post));

    }
}

class PostService 
{
    function calculateAuthorWords($author)
    {
        $wordsCount = 0;
        foreach ($author->posts as $posts) {
             $wordsCount += str_word_count($posts->text);
        }
        return $wordsCount;
    }
}

class SendPostUpdatedJob implements  ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
       
    private $post;
    public function __construct(Post $post) 
       {
           $this->post = $post;
       }
       
    
    public function handle() {
    $admin = User::where('role', 'admin')->first();
    if($admin) {
            $admin->notify(new PostUpdatedNotification($this->post));
    }    

}
}

class PostUpdatedNotification extends Notification
{
    use Queueable;
       
    private $post;

    public function __construct(Post $post) 
    {
        $this->post = $post;
    }
    
    public function via($notifiable)
    {
        return ['mail'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Пост был обновлен'. $this->post->title);
            
    }
}

class PostController extends Controller
{
    public function update(Post $post, PostUpdateRequest $request)
    {
        $post->update($request->only(['title', 'text', 'is_active']));
        
        return redirect()->route('admin.posts.index');      
    }
}
```



