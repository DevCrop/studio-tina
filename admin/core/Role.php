<?php

class Role
{
    private string $role;

    public function __construct(?string $role = null)
    {
        $this->role = $role ?? ($_SESSION['no_adm_login_role'] ?? 'guest');
    }

    public function is(string $roleName): bool
    {
        return $this->role === $roleName;
    }

    public function in(array $allowedRoles): bool
    {
        return in_array($this->role, $allowedRoles, true);
    }

    public function canDelete(): bool
    {
        return $this->in(['superadmin', 'manager']);
    }

    public function canEditState(): bool
    {
        return !$this->is('external');
    }

    public function getName(): string
    {
        return $this->role;
    }

	public function canViewMenu(string $menuKey): bool
	{
		if ($this->is('external')) {
			return $menuKey === 'request';
		}

		return true;
	}


    public function getLabel(): string
    {
        $labels = [
            'superadmin' => '최고 관리자',
            'manager'    => '중간 관리자',
            'external'   => '외부 사용자',
            'guest'      => '게스트'
        ];
        return $labels[$this->role] ?? '알 수 없음';
    }
}