<h1>Главная страница</h1>

<p>Контроллер.</p>

<pre><code>namespace App\Controllers;
class Home extends BaseController
{
	public function index()
	{
		return view('home');
	}
}</code></pre>

<b>1.</b> Ночной дизайн может менять только на центральной (необходима авторизация).<br><br>

Задача была изучить: routes, get / post, связь с контроллером, ajax, csrf (глобально), <br> модель, глобальные переменные, работу с сессиями и кеширование.<br><br>

<b>2.</b>  Изучить новую для меня модель построения шаблонов.<br>
<b>3.</b> Миграцию в этой системе.<br>

<br>