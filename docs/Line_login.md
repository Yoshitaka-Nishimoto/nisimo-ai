laravel12 livewire,ngrok でline loginを作りたい。すでに、lineにプロバイダーpianisimoは、作成済みで、line loginとmessging apiが紐ずいています。line loginの設定手順を教えて。

1 composer require laravel/socialite [current working directory /home/nimo/pinpon] (Laravel Socialiteをインストールします。)
2 composer require socialiteproviders/line [current working directory /home/nimo/pinpon](Socialite Providers for LINEをインストールします。)
composer.json
 "require": {
        "laravel/socialite": "^5.23",
        "socialiteproviders/line": "^4.1"
3 app/.../AppServiceProvider.php:     public function boot(): vo... =>     public function boot(): vo...  
22 -         //                                                                                               
22 +         $this->app['events']->listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {  
23 +             $event->extendSocialite('line', \SocialiteProviders\Line\Provider::class);                   
24 +         });                                                                                              

4 config/services.phpの内容を確認しました。それでは、ファイルの末尾にLINEの設定を追加します。
 38 +     'line' => [                                      
 39 +         'client_id' => env('LINE_CLIENT_ID'),        
 40 +         'client_secret' => env('LINE_CLIENT_SECRET'),
 41 +         'redirect' => env('LINE_REDIRECT_URI'),      
 42 +     ],                                               
 43 +                                                      
 44   ];      

 以下のコマンドでマイグレーションファイルを作成します。
╭────────────────────────────────────────────────────────────────────────────────────────────────╮
│ ?  Shell php artisan make:migration add_line_id_to_users_table --table=users [current working directory /home/nimo/pinpon] (`users`テーブルに`line_id`カラムを追加するためのマイグレーションファイルを作成します。)   ← │
│                                                                                      │
│ php artisan make:migration add_line_id_to_users_table --table=users        

5  php artisan make:migration add_line_id_to_users_table --table=users [current working directory /home/nimo/pinpon] (`users`テーブルに`line_id`カラムを追加するためのマイグレーションファイルを作成します。)  
INFO  Migration [database/migrations/2025_12_07_085700_add_line_id_to_users_table.php] created successfully.                                                                                                         │
╰────────────────────────────────────────────────────────────────────────────────────────────────────────────╯
✦ マイグレーションファイルが作成されました。次に、作成されたファイルを開き、line_idカラムを追加するコードを記述します。

  作成されたマイグレーションファイルdatabase/migrations/YYYY_MM_DD_HHMMSS_add_line_id_to_users_table.phpを編集します。
  upメソッドにline_idカラムを追加し、downメソッドでそのカラムを削除する処理を記述します。
6 INFO  Migration [database/migrations/2025_12_07_085700_add_line_id_to_users_table.php] created successfully.                                                                                                         │
╰────────────────────────────────────────────────────────────────────────────────────────────────────────────────╯
✦ マイグレーションファイルが作成されました。次に、作成されたファイルを開き、line_idカラムを追加するコードを記述します。

  作成されたマイグレーションファイルdatabase/migrations/YYYY_MM_DD_HHMMSS_add_line_id_to_users_table.phpを編集します。
  upメソッドにline_idカラムを追加し、downメソッドでそのカラムを削除する処理を記述します。  
  7 2025_12_07_085700_add_line_id_to_users_table ............................................................................................. 1s DONE                                                                    │
╰────────────────────────────────────────────────────────────────────────────────────────╯
✦ データベースの準備が整いました。

  ステップ5: ルーティングとコントローラーの設定

  LINEログイン処理のためのルートとコントローラーを作成します。

   1. コントローラーの作成
      以下のコマンドでLineLoginControllerを作成します。

8 php artisan make:controller LineLoginController [current working directory /home/nimo/pinpon] (LINEログイン処理用の`LineLoginController`を作成します。)       
9  2. ルーティングの追加
      routes/web.phpに、LINEへのリダイレクトとコールバック処理のルートを追加します。
3 + use App\Http\Controllers\LineLoginController; 
12 + Route::get('/auth/line/redirect', [LineLoginController::class, 'redirectToLine'])->name('line.login');
13 + Route::get('/auth/line/callback', [LineLoginController::class, 'handleLineCallback']);                
14 +                                                                                                       
15   Route::view('dashboard', 'dashboard')  

10  3. コントローラーの実装
      app/Http/Controllers/LineLoginController.phpに、リダイレクトとコールバックのロジックを実装します。

       * redirectToLine: Socialiteを使ってLINEの認証ページにリダイレクトします。
       * handleLineCallback: LINEからのコールバックを受け取り、ユーザー情報を取得します。line_idを元にユーザーを検索、存在しない場合は新規作成してログインさせます。
      以下の内容でapp/Http/Controllers/LineLoginController.phpを上書きしてください。
WriteFile Writing to app/.../LineLoginController.php   
 WriteFile Writing to app/.../LineLoginController.php                                          
                                                                                               
 2                                                                                             
 3   namespace App\Http\Controllers;                                                           
 4                                                                                             
 5 + use App\Models\User;                                                                      
 6   use Illuminate\Http\Request;                                                              
 7 + use Illuminate\Support\Facades\Auth;                                                      
 8 + use Illuminate\Support\Str;                                                               
 9 + use Laravel\Socialite\Facades\Socialite;                                                  
10                                                                                             
11   class LineLoginController extends Controller                                              
12   {                                                                                         
 9 -     //                                                                                    
13 +     /**                                                                                   
14 +      * Redirect the user to the LINE authentication page.                                 
15 +      *                                                                                    
16 +      * @return \Illuminate\Http\RedirectResponse                                          
17 +      */                                                                                   
18 +     public function redirectToLine()                                                      
19 +     {                                                                                     
20 +         return Socialite::driver('line')->redirect();                                     
21       }                                                                                     
22 +                                                                                           
23 +     /**                                                                                   
24 +      * Obtain the user information from LINE.                                             
25 +      *                                                                                    
26 +      * @return \Illuminate\Http\RedirectResponse                                          
27 +      */                                                                                   
28 +     public function handleLineCallback()                                                  
29 +     {                                                                                     
30 +         try {                                                                             
31 +             $lineUser = Socialite::driver('line')->user();                                
32 +         } catch (\Exception $e) {                                                         
33 +             return redirect('/')->with('error', 'LINEでのログインに失敗しました。');      
34 +         }                                                                                 
35 +                                                                                           
36 +         $user = User::updateOrCreate([                                                    
37 +             'line_id' => $lineUser->getId(),                                              
38 +         ], [                                                                              
39 +             'name' => $lineUser->getName(),                                               
40 +             'email' => $lineUser->getEmail(),                                             
41 +             'password' => bcrypt(Str::random(16)), // パスワードは不要だが念のため設定    
42 +         ]);                                                                               
43 +                                                                                           
44 +         Auth::login($user, true);                                                         
45 +                                                                                           
46 +         return redirect()->intended('dashboard');                                         
47 +     }                                                                                     
48 + }      

                                                       
... first 41 lines hidden ...                          
42 +         ]);                                       
43 +                                                   
44 +         Auth::login($user, true);                 
45 +                                                   
46 +         return redirect()->intended('dashboard'); 
47 +     }                                             
48 + }                                                 
                                                       
11 LINEログインボタンの設置が完了しました。
  緑色のLINE公式カラーをボタンの背景色として使用しました。

  最終ステップ：ngrokとLINE Developersコンソールの設定

   1. ngrokの起動: ターミナルで以下のコマンドを実行し、ローカルサーバーを外部に公開します。

   1     ngrok http 8000

   2. コールバックURLの設定:
       * ngrokが生成したhttpsから始まるURL（例: https://xxxxxxxx.ngrok-free.app）をコピーします。
       * LINE Developersコンソールにログインし、対象のプロバイダーを選択します。
       * 「LINEログイン設定」タブを開きます。
       * 「コールバックURL」の編集ボタンを押し、https://xxxxxxxx.ngrok-free.app/auth/line/callback のように、コピーしたURLの末尾に/auth/line/callbackを追加したものを設定します。

   3. .envファイルの更新:
       * .envファイルのLINE_REDIRECT_URIを、上記で設定したコールバックURLに更新したことを確認してください。
       * APP_URLもngrokのURLに設定することをお勧めします。

   1     APP_URL=https://xxxxxxxx.ngrok-free.app
   2     LINE_CLIENT_ID=YOUR_LINE_CLIENT_ID
   3     LINE_CLIENT_SECRET=YOUR_LINE_CLIENT_SECRET
   4     LINE_REDIRECT_URI=https://xxxxxxxx.ngrok-free.app/auth/line/callback

   4. 設定のキャッシュクリア:
      .envファイルを変更した後は、以下のコマンドで設定のキャッシュをクリアしてください。
# Line アカントでログインすると400 に成る。  
  解決策1：ログインしたいアカウントを開発者として登録する（推奨）

  テストや開発を行うための最も簡単な方法です。

   1. LINE Developersコンソール (https://developers.line.biz/console/) にログインします。
   2. 対象のプロバイダーとLINEログインチャネルを選択します。
   3. 「ロール」 タブを開きます。
   4. 「メンバーを招待」ボタンを押し、ログインを試したいご自身のLINEアカウントに紐づくメールアドレスを入力して、「開
      発者」として追加します。
   5. 追加されたLINEアカウントで、再度ログインをお試しください。

  解決策2：チャネルを「公開」ステータスにする

  一般のLINEユーザーにログイン機能を公開する場合は、こちらの対応が必要です。

   1. LINE Developersコンソール (https://developers.line.biz/console/) にログインします。
   2. 対象のプロバイダーとLINEログインチャネルを選択します。
   3. 「チャネル基本設定」 タブを開きます。
   4. ページの下部にある「チャネルステータス」が「開発中」になっているので、これを「公開」に変更します。
       * 注意：一度「公開」にすると、「開発中」に戻すことはできません。
       
# Line Login メールアドレス取得　権限の　申請ボタン
OpenID Connect
メールアドレス取得権限 
申請済み
