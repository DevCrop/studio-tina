<?php

namespace Menu;

final class Menu
{
    /** 전역 레지스트리: 이름 → Menu 인스턴스 */
    public static array $created = [];

    /** 내부 자동 ID 시드 */
    private static int $menuCount = 1;

    /** 고유 ID */
    private int $id;

    /** @var string 메뉴 식별/표시용 이름 */
    private string $name;

    /** @var MenuItem[] 평면 구조의 아이템 목록 */
    private array $items = [];

    public function __construct(string $name = 'default', ?int $id = null)
    {
        $this->name = $name;
        $this->id   = $id ?? self::$menuCount++;

        self::$created[$name] = $this;
    }

    /** 선택: 이름으로 조회 */
    public static function get(string $name): ?self
    {
        return self::$created[$name] ?? null;
    }

    /** 메뉴 ID 조회 */
    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * 아이템 추가 (필수: label, url, slug)
     * @param array{
     *   parent?: MenuItem|null,
     *   orderIndex?: int,
     *   isBlank?: bool,
     *   isVisible?: bool
     * } $options
     */
    public function add(string $label, string $url, string $slug, array $options = [], ?int $id = null): MenuItem
    {
        $item = new MenuItem($label, $url, $slug, $this, $options, $id);
        $this->items[] = $item;

        if ($parent = $item->parent()) {
            $parent->addChild($item);
        }

        return $item;
    }

    /** 수동으로 아이템 추가 (이미 생성된 MenuItem) */
    public function addItem(MenuItem $item): self
    {
        if ($item->menu() !== $this) {
            throw new \InvalidArgumentException('MenuItem belongs to a different Menu instance.');
        }
        $this->items[] = $item;
        if ($parent = $item->parent()) {
            $parent->addChild($item);
        }
        return $this;
    }

    /** @return MenuItem[] 모든 아이템(가시성 무시, 평면) */
    public function allItems(): array
    {
        return $this->items;
    }

    /** @return MenuItem[] 최상위 아이템만 */
    public function rootItems(bool $visibleOnly = true): array
    {
        $roots = array_filter($this->items, static function (MenuItem $i) use ($visibleOnly) {
            if ($visibleOnly && !$i->isVisible()) return false;
            return $i->parent() === null;
        });

        usort($roots, static fn(MenuItem $a, MenuItem $b) => $a->orderIndex() <=> $b->orderIndex());
        return $roots;
    }

    public function findByLabel(string $label): ?MenuItem
    {
        foreach ($this->items as $item) {
            if ($item->label() === $label) return $item;
        }
        return null;
    }

    public function findByUrl(string $url): ?MenuItem
    {
        foreach ($this->items as $item) {
            if ($item->url() === $url) return $item;
        }
        return null;
    }

    public function findBySlug(string $slug): ?MenuItem
    {
        foreach ($this->items as $item) {
            if ($item->slug() === $slug) return $item;
        }
        return null;
    }

    /** 트리 형태 배열로 변환 (렌더링/직렬화 용) */
    public function toArray(bool $visibleOnly = true): array
    {
        $build = function (MenuItem $item) use (&$build, $visibleOnly): array {
            $children = [];
            foreach ($item->children($visibleOnly) as $child) {
                $children[] = $build($child);
            }
            return [
                'id'         => $item->id(),
                'slug'       => $item->slug(),
                'label'      => $item->label(),
                'url'        => $item->url(),
                'target'     => $item->target(),
                'orderIndex' => $item->orderIndex(),
                'isBlank'    => $item->isBlank(),
                'isVisible'  => $item->isVisible(),
                'children'   => $children,
            ];
        };

        $result = [];
        foreach ($this->rootItems($visibleOnly) as $root) {
            $result[] = $build($root);
        }
        return $result;
    }

    /**
     * 간단한 HTML 렌더러 (원한다면 분리 가능)
     * - $ulClass, $liClass 로 클래스 제어
     */
    public function render(string $ulClass = 'menu', string $liClass = 'menu-item'): string
    {
        $renderItems = function (array $items) use (&$renderItems, $ulClass, $liClass): string {
            if (!$items) return '';
            $html = '<ul class="' . htmlspecialchars($ulClass, ENT_QUOTES, 'UTF-8') . '">';
            foreach ($items as $item) {
                /** @var MenuItem $item */
                $html .= '<li class="' . htmlspecialchars($liClass, ENT_QUOTES, 'UTF-8') . '">';
                $html .= sprintf(
                    '<a href="%s" target="%s">%s</a>',
                    htmlspecialchars($item->url(), ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($item->target(), ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($item->label(), ENT_QUOTES, 'UTF-8')
                );
                $children = $item->children(true);
                if (!empty($children)) {
                    $html .= $renderItems($children);
                }
                $html .= '</li>';
            }
            $html .= '</ul>';
            return $html;
        };

        return $renderItems($this->rootItems(true));
    }
}
