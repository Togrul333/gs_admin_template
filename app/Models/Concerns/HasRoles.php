<?php

namespace App\Models\Concerns;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * A user may have multiple roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_user', 'user_id', 'role_id');
    }

    /**
     * Determine if the user has the given role.
     *
     * @param mixed $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }

        if (is_int($role)) {
            return $this->roles->contains('id', $role);
        }

        return (bool) $role->intersect($this->roles)->count();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        $permission = Permission::get($permission);
        if ($permission){
            if (in_array($this->id,$permission->users->pluck('id')->toArray())){
                return true;
            }
            return $this->hasRole($permission->roles);
        }else{
            return false;
        }
    }

    /**
     * Determine if the user is a developer.
     *
     * @return bool
     */
    public function getIsDeveloperAttribute()
    {
        return $this->hasRole('developer');
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->hasRole('admin');
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function getIsUserAttribute()
    {
        return $this->hasRole('user');
    }

    /**
     * Determine if the user is an editor.
     *
     * @return bool
     */
    public function getIsEditorAttribute()
    {
        return $this->hasRole('editor');
    }



    /**
     * Determine if the user is an editor.
     *
     * @return bool
     */
    public function getTenderAttribute()
    {
        return $this->hasRole('tender');
    }

    /**
     * Determine if the user is an editor.
     *
     * @return bool
     */
    public function getKadrAttribute()
    {
        return $this->hasRole('kadr');
    }

    /**
     * Determine if the user is an electron.
     *
     * @return bool
     */
    public function getIsElectronIsciAttribute()
    {
        return $this->hasRole('electron');
    }

    /**
     * Determine if the user is an electron mudir.
     *
     * @return bool
     */
    public function getIsElectronMudirAttribute()
    {
        return $this->hasRole('electron-mudir');
    }

    /**
     * Get the role of the user.
     *
     * @return static|null
     */
    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    /**
     * Determine if the user is a developer or an admin.
     *
     * @return bool
     */
    public function getAdminAttribute()
    {
        return $this->isDeveloper or $this->isAdmin;
    }

    /**
     * Determine if the user is a company or an support.
     *
     * @return bool
     */
    public function getElectronAttribute()
    {
        return $this->isElectronIsci or $this->isElectronMudir;
    }

    /**
     * Determine if the user is a company or an support.
     *
     * @return bool
     */
    public function getElectronAdminAttribute()
    {
        return $this->admin or $this->isElectronMudir;
    }
}
