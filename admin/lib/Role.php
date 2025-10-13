<?php

    class Role {
    private string $code;
    private int $id;

    public function __construct(?int $roleId = null)
    {
        global $admin_roles;

        $this->id = $roleId ?? ($_SESSION['no_adm_login_role_id'] ?? 3);
        $this->code = $admin_roles[$this->id]['code'] ?? 'guest';
    }

    public function is(string $roleCode): bool
    {
        return $this->code === $roleCode;
    }

    public function in(array $allowedCodes): bool
    {
        return in_array($this->code, $allowedCodes, true);
    }

    public function canEdit(): bool
    {
        return $this->is('superadmin');
    }

    public function canDelete(): bool
    {
        return $this->in(['superadmin', 'manager']);
    }

    public function canViewMenu(string $menuKey): bool
    {
        if ($this->is('external')) {
            return $menuKey === 'request';
        }
        return true;
    }

    public function getName(): string
    {
        global $admin_roles;
        return $admin_roles[$this->id]['name'] ?? '알 수 없음';
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getRestrictedMenuKeys(): array
    {
        $restricted = [];

        if ($this->is('external')) {
            $restricted = array_merge($restricted, ['account', 'user', 'setting', 'inquiry']);
        }

        if ($this->is('manager')) {
            $restricted = array_merge($restricted, ['account', 'user']);
        }

        return array_unique($restricted);
    }


}