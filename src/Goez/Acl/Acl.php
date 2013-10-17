<?php

namespace Goez\Acl;

class Acl
{
    protected $_roles = array();

    /**
     * @param string $name
     * @return \Goez\Acl\Acl
     */
    public function addRole($name)
    {
        $name = strtolower($name);

        if (!$this->hasRole($name)) {
            $this->_roles[$name] = new Role($name);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRole($name)
    {
        return in_array(strtolower($name), array_keys($this->_roles));
    }

    /**
     * @param string $name
     * @return \Goez\Acl\Role
     * @throws \Goez\Acl\Exception
     */
    public function getRole($name)
    {
        $name = strtolower($name);
        if ($this->hasRole($name)) {
            return $this->_roles[$name];
        }

        throw new Exception("Can't find role of '$name'.");
    }

    /**
     * @param mixed $roleIdentify
     * @param mixed $action
     * @param mixed $resource
     * @return \Goez\Acl\Acl
     */
    public function allow($roleIdentify, $action, $resource)
    {
        if (!$this->hasRole($roleIdentify)) {
            $this->addRole($roleIdentify);
        }

        $this->getRole($roleIdentify)->allow($action, $resource);
        return $this;
    }

    /**
     * @param mixed $roleIdentify
     * @param mixed $action
     * @param mixed $resource
     * @return \Goez\Acl\Acl
     */
    public function deny($roleIdentify, $action, $resource)
    {
        if (!$this->hasRole($roleIdentify)) {
            $this->addRole($roleIdentify);
        }

        $this->getRole($roleIdentify)->deny($action, $resource);
        return $this;
    }

    /**
     * @param mixed $roleIdentify
     * @param mixed $action
     * @param mixed $resource
     * @return bool
     */
    public function can($roleIdentify, $action, $resource)
    {
        if (!$this->hasRole($roleIdentify)) {
            $this->addRole($roleIdentify);
        }

        return $this->getRole($roleIdentify)->can($action, $resource);
    }
}
