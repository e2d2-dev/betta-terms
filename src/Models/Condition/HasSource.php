<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Enums\Source;
use Illuminate\Database\Eloquent\Builder as EloBuilder;

/**
 * @property array $data
 * @property Source $source
 * @property ?string $file
 * @property ?string $url
 * @property bool $has_file
 */
trait HasSource
{
    protected function initializeHasSource(): void
    {
        $this->mergeCasts([
            'source' => Source::class,
            'text' => 'string',
            'has_file' => 'bool',
            'data' => 'array',
        ]);

        $this->mergeFillable([
            'source',
            'text',
            'file',
            'url',
            'has_file',
            'data',
        ]);
    }

    public function hasSource(): bool
    {
        return (bool) $this->source;
    }

    public function scopeHasSource(EloBuilder $query): void
    {
        $query->whereNotNull('source');
    }

    public function scopeSource(EloBuilder $query, Source $source): void
    {
        $query->where('source', $source);
    }

    public function hasText(): bool
    {
        return filled($this->getText());
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function hasEmbedUrl(): bool
    {
        return in_array($this->source, [Source::Image, Source::Iframe, Source::Pdf]);
    }

    public function getEmbedUrl(): ?string
    {
        return $this->hasFile()
            ? $this->getFileUrl()
            : $this->getUrl();
    }

    public function getFileUrl(): ?string
    {
        if (! $this->hasFile()) {
            return null;
        }

        return asset($this->file);
    }

    public function hasFile(): bool
    {
        return $this->has_file && $this->file;
    }

    public function getText(): ?string
    {
        return $this->text ?? null;
    }

    public function hasUrl(): bool
    {
        return filled($this->url);
    }

    public function hasFileOrUrlFilled(): bool
    {
        return $this->hasFile() || $this->hasUrl();
    }

    public function hasMarkdown(): bool
    {
        return $this->source === Source::Markdown and (! empty($this->data) or $this->hasFile());
    }

    public function getMarkdown()
    {
        return $this->data;
    }

    public function hasValidSource(): bool
    {
        return match ($this->source) {
            Source::Text => $this->hasText(),
            Source::Link => $this->hasUrl(),
            Source::Pdf, Source::Iframe, Source::Image => $this->hasFileOrUrlFilled(),
            Source::Simple => true,
            Source::Markdown => $this->hasMarkdown(),
            default => false,
        };
    }
}
