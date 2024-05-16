<?php

namespace App\Http\Controllers;

use App\Models\Article;
use League\CommonMark\MarkdownConverterInterface;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

class ArticleController extends Controller
{
    protected $environment;
    protected $converter;

    public function __construct()
    {
        $config = [
            'renderer' => [
                'block_separator' => "\n",
                'inner_separator' => "\n",
                'soft_break'      => "\n",
            ],
            'heading_permalink' => [
                'html_class' => 'permalink',
                'id_prefix' => 'user-content',
                'insert' => 'before',
                'title' => 'Permalink',
                'symbol' => '#',
            ]
        ];
        $this->environment = new Environment($config);
        $this->environment->addExtension(new CommonMarkCoreExtension());
        $this->environment->addExtension(new AttributesExtension());
        $this->environment->addExtension(new HeadingPermalinkExtension());
        $this->environment->addExtension(new FrontMatterExtension());
        $this->converter = new MarkdownConverter($this->environment);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($path = null)
    {
        if(!$path) {
            $articles = Article::orderBy('date')
                ->paginate(6);
            return view('articles.index', get_defined_vars());
        }
        return $this->articles($path);
    }

    private function articles($path) {
        $path = $path;
        $article = Article::where('path', $path)->first();
        if (!$article) {
            abort(404);
        }
        $article->view = $this->converter->convertToHtml(file_get_contents(resource_path().'/views/articles/'.$path.'.md'));
        return view('articles.layout', get_defined_vars());
    }
}
