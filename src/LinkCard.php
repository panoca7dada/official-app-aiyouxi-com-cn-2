<?php

namespace App\Helpers;

class LinkCard
{
    private string $title;
    private string $description;
    private string $url;
    private string $keyword;
    private string $domain;
    private array $metrics;

    public function __construct(
        string $title = '爱游戏 - 你的游戏世界',
        string $description = '探索无限精彩的游戏体验，尽在爱游戏平台。',
        string $url = 'https://official-app-aiyouxi.com.cn',
        string $keyword = '爱游戏'
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->keyword = $keyword;
        $this->domain = parse_url($url, PHP_URL_HOST) ?? '';
        $this->metrics = [
            'visits' => 12480,
            'rating' => 4.8,
            'reviews' => 3521,
        ];
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        $this->domain = parse_url($url, PHP_URL_HOST) ?? '';
        return $this;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;
        return $this;
    }

    public function setMetrics(array $metrics): self
    {
        $this->metrics = $metrics;
        return $this;
    }

    public function render(): string
    {
        $title = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $description = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $url = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $keyword = htmlspecialchars($this->keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $domain = htmlspecialchars($this->domain, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $visits = (int)($this->metrics['visits'] ?? 0);
        $rating = (float)($this->metrics['rating'] ?? 0);
        $reviews = (int)($this->metrics['reviews'] ?? 0);

        $starRating = str_repeat('★', max(0, min(5, (int)round($rating)))) .
                      str_repeat('☆', max(0, 5 - max(0, min(5, (int)round($rating)))));

        $html = <<<HTML
<div class="link-card" data-keyword="{$keyword}">
    <div class="link-card-header">
        <span class="link-card-domain">{$domain}</span>
        <span class="link-card-badge">{$keyword}</span>
    </div>
    <div class="link-card-body">
        <h3 class="link-card-title">{$title}</h3>
        <p class="link-card-description">{$description}</p>
    </div>
    <div class="link-card-footer">
        <div class="link-card-metrics">
            <span class="metric metric-visits">访问: {$visits}</span>
            <span class="metric metric-rating">{$starRating} ({$rating})</span>
            <span class="metric metric-reviews">评价: {$reviews}</span>
        </div>
        <a href="{$url}" class="link-card-button" target="_blank" rel="noopener noreferrer">前往</a>
    </div>
</div>
HTML;

        return $html;
    }

    public function renderWithStyle(string $extraStyles = ''): string
    {
        $baseStyles = <<<CSS
<style>
.link-card {
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    max-width: 400px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    transition: box-shadow 0.3s ease;
}
.link-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.link-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.link-card-domain {
    color: #666;
    font-size: 0.85em;
}
.link-card-badge {
    background: #667eea;
    color: white;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 0.75em;
    font-weight: 600;
}
.link-card-body {
    margin-bottom: 16px;
}
.link-card-title {
    margin: 0 0 8px 0;
    font-size: 1.2em;
    color: #1a1a1a;
}
.link-card-description {
    margin: 0;
    color: #555;
    line-height: 1.5;
    font-size: 0.95em;
}
.link-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #eee;
    padding-top: 14px;
}
.link-card-metrics {
    display: flex;
    gap: 12px;
    font-size: 0.8em;
    color: #777;
}
.metric {
    white-space: nowrap;
}
.metric-rating {
    color: #f5a623;
}
.link-card-button {
    display: inline-block;
    padding: 6px 18px;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 500;
    transition: background 0.2s ease;
}
.link-card-button:hover {
    background: #5a6fd6;
}
</style>
CSS;

        return $baseStyles . $this->render();
    }
}