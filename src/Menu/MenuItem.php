<?php

namespace Menu;

final class MenuItem
{
    /** 자동 ID 시드 */
    protected static int $itemCount = 1;

    private ?int $id = null;
    private ?MenuItem $parent = null;
    private Menu $menu;

    private string $label;
    private string $url;

    /** 고유키 (슬러그) */
    private string $slug;

    private int $orderIndex = 0;
    private bool $isBlank = false;
    private bool $isVisible = true;

    /** @var MenuItem[] */
    private array $children = [];

    /**
     * 필수: $label, $url, $slug, $menu
     * 옵션:
     *  - parent: MenuItem|null
     *  - orderIndex: int (기본 0)
     *  - isBlank: bool (기본 false)
     *  - isVisible: bool (기본 true)
     * @param array{
     *   parent?: MenuItem|null,
     *   orderIndex?: int,
     *   isBlank?: bool,
     *   isVisible?: bool
     * } $options
     */
    public function __construct(
        string $label,
        string $url,
        string $slug,
        Menu $menu,
        array $options = [],
        ?int $id = null
    ) {
        $this->label = $label;
        $this->url   = $url;
        $this->slug  = $slug;
        $this->menu  = $menu;

        $this->orderIndex = (int)($options['orderIndex'] ?? 0);
        $this->isBlank    = (bool)($options['isBlank'] ?? false);
        $this->isVisible  = (bool)($options['isVisible'] ?? true);

        if (array_key_exists('parent', $options) && $options['parent'] instanceof self) {
            $this->parent = $options['parent'];
        }

        // ID 부여 (주입 시 그대로 사용, 아니면 자동증가)
        $this->id = $id ?? static::$itemCount++;
    }

    /** 팩토리 헬퍼 */
    public static function make(string $label, string $url, string $slug, Menu $menu, array $options = [], ?int $id = null): self
    {
        return new self($label, $url, $slug, $menu, $options, $id);
    }

    // ----------- getters -----------
    public function id(): ?int
    {
        return $this->id;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function menu(): Menu
    {
        return $this->menu;
    }

    public function parent(): ?self
    {
        return $this->parent;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function orderIndex(): int
    {
        return $this->orderIndex;
    }

    public function isBlank(): bool
    {
        return $this->isBlank;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    /** @return MenuItem[] */
    public function children(bool $visibleOnly = true): array
    {
        $children = $visibleOnly
            ? array_filter($this->children, static fn(self $c) => $c->isVisible())
            : $this->children;

        usort($children, static fn(self $a, self $b) => $a->orderIndex <=> $b->orderIndex);
        return $children;
    }

    // ----------- modifiers -----------
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        if ($parent) {
            $parent->addChild($this);
        }
        return $this;
    }

    public function addChild(self $child): self
    {
        if ($child->menu() !== $this->menu) {
            throw new \InvalidArgumentException('Child MenuItem belongs to a different Menu instance.');
        }
        foreach ($this->children as $c) {
            if ($c === $child) return $this;
        }
        $this->children[] = $child;
        if ($child->parent() !== $this) {
            $child->parent = $this; // 내부 역참조 정합성
        }
        return $this;
    }

    public function setOrderIndex(int $orderIndex): self
    {
        $this->orderIndex = $orderIndex;
        return $this;
    }

    public function openInNewTab(bool $flag = true): self
    {
        $this->isBlank = $flag;
        return $this;
    }

    public function show(): self
    {
        $this->isVisible = true;
        return $this;
    }

    public function hide(): self
    {
        $this->isVisible = false;
        return $this;
    }

    public function target(): string
    {
        return $this->isBlank ? '_blank' : '_self';
    }

    public function toArray(bool $withChildren = true, bool $visibleOnly = true): array
    {
        $data = [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'label'      => $this->label,
            'url'        => $this->url,
            'target'     => $this->target(),
            'orderIndex' => $this->orderIndex,
            'isBlank'    => $this->isBlank,
            'isVisible'  => $this->isVisible,
        ];

        if ($withChildren) {
            $data['children'] = array_map(
                fn(self $c) => $c->toArray(true, $visibleOnly),
                $this->children($visibleOnly)
            );
        }
        return $data;
    }
}
