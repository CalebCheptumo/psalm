<?php
namespace Psalm\Storage;

use Psalm\CodeLocation;
use Psalm\Internal\MethodIdentifier;
use Psalm\Type;

class ClassLikeStorage
{
    use CustomMetadataTrait;

    /**
     * A lookup table for public class constants
     *
     * @var array<string, Type\Union>
     */
    public $public_class_constants = [];

    /**
     * A lookup table for protected class constants
     *
     * @var array<string, Type\Union>
     */
    public $protected_class_constants = [];

    /**
     * A lookup table for private class constants
     *
     * @var array<string, Type\Union>
     */
    public $private_class_constants = [];

    /**
     * A lookup table for class constant name locations
     *
     * @var array<string, CodeLocation>
     */
    public $class_constant_locations = [];

    /**
     * A lookup table for class constant statement locations
     *
     * @var array<string, CodeLocation>
     */
    public $class_constant_stmt_locations = [];

    /**
     * A lookup table for nodes of unresolvable public class constants
     *
     * @var array<string, \Psalm\Internal\Scanner\UnresolvedConstantComponent>
     */
    public $public_class_constant_nodes = [];

    /**
     * A lookup table for nodes of unresolvable protected class constants
     *
     * @var array<string, \Psalm\Internal\Scanner\UnresolvedConstantComponent>
     */
    public $protected_class_constant_nodes = [];

    /**
     * A lookup table for nodes of unresolvable private class constants
     *
     * @var array<string, \Psalm\Internal\Scanner\UnresolvedConstantComponent>
     */
    public $private_class_constant_nodes = [];

    /**
     * Aliases to help Psalm understand constant refs
     *
     * @var ?\Psalm\Aliases
     */
    public $aliases;

    /**
     * @var bool
     */
    public $populated = false;

    /**
     * @var bool
     */
    public $stubbed = false;

    /**
     * @var bool
     */
    public $deprecated = false;

    /**
     * @var bool
     */
    public $internal = false;

    /**
     * @var null|string
     */
    public $psalm_internal = null;

    /**
     * @var null|Type\Atomic\TTemplateParam|Type\Atomic\TNamedObject
     */
    public $mixin = null;

    /**
     * @var array<string, bool>
     */
    public $deprecated_constants = [];

    /**
     * @var bool
     */
    public $sealed_properties = false;

    /**
     * @var bool
     */
    public $sealed_methods = false;

    /**
     * @var bool
     */
    public $override_property_visibility = false;

    /**
     * @var bool
     */
    public $override_method_visibility = false;

    /**
     * @var array<int, string>
     */
    public $suppressed_issues = [];

    /**
     * @var string
     */
    public $name;

    /**
     * Is this class user-defined
     *
     * @var bool
     */
    public $user_defined = false;

    /**
     * Interfaces this class implements directly
     *
     * @var array<string, string>
     */
    public $direct_class_interfaces = [];

    /**
     * Interfaces this class implements explicitly and implicitly
     *
     * @var array<lowercase-string, string>
     */
    public $class_implements = [];

    /**
     * Parent interfaces listed explicitly
     *
     * @var array<lowercase-string, string>
     */
    public $direct_interface_parents = [];

    /**
     * Parent interfaces
     *
     * @var  array<lowercase-string, string>
     */
    public $parent_interfaces = [];

    /**
     * There can only be one direct parent class
     *
     * @var ?string
     */
    public $parent_class;

    /**
     * Parent classes
     *
     * @var array<lowercase-string, string>
     */
    public $parent_classes = [];

    /**
     * @var CodeLocation|null
     */
    public $location;

    /**
     * @var CodeLocation|null
     */
    public $stmt_location;

    /**
     * @var CodeLocation|null
     */
    public $namespace_name_location;

    /**
     * @var bool
     */
    public $abstract = false;

    /**
     * @var bool
     */
    public $final = false;

    /**
     * @var array<lowercase-string, string>
     */
    public $used_traits = [];

    /**
     * @var array<lowercase-string, lowercase-string>
     */
    public $trait_alias_map = [];

    /**
     * @var array<string, int>
     */
    public $trait_visibility_map = [];

    /**
     * @var bool
     */
    public $is_trait = false;

    /**
     * @var bool
     */
    public $is_interface = false;

    /**
     * @var bool
     */
    public $external_mutation_free = false;

    /**
     * @var bool
     */
    public $mutation_free = false;

    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $methods = [];

    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $pseudo_methods = [];

    /**
     * @var array<lowercase-string, MethodStorage>
     */
    public $pseudo_static_methods = [];

    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $declaring_method_ids = [];

    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $appearing_method_ids = [];

    /**
     * @var array<lowercase-string, array<string, MethodIdentifier>>
     */
    public $overridden_method_ids = [];

    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $documenting_method_ids = [];

    /**
     * @var array<lowercase-string, MethodIdentifier>
     */
    public $inheritable_method_ids = [];

    /**
     * @var array<lowercase-string, array<string, bool>>
     */
    public $potential_declaring_method_ids = [];

    /**
     * @var array<string, PropertyStorage>
     */
    public $properties = [];

    /**
     * @var array<string, Type\Union>
     */
    public $pseudo_property_set_types = [];

    /**
     * @var array<string, Type\Union>
     */
    public $pseudo_property_get_types = [];

    /**
     * @var array<string, string>
     */
    public $declaring_property_ids = [];

    /**
     * @var array<string, string>
     */
    public $appearing_property_ids = [];

    /**
     * @var array<string, string>
     */
    public $inheritable_property_ids = [];

    /**
     * @var array<string, array<string>>
     */
    public $overridden_property_ids = [];

    /**
     * @var array<string, non-empty-array<string, array{Type\Union}>>|null
     */
    public $template_types;

    /**
     * @var array<int, bool>|null
     */
    public $template_covariants;

    /**
     * @var array<string, array<int|string, Type\Union>>|null
     */
    public $template_type_extends;

    /**
     * @var ?int
     */
    public $template_type_extends_count;

    /**
     * @var array<string, int>|null
     */
    public $template_type_implements_count;

    /**
     * @var ?Type\Union
     */
    public $yield;

    /**
     * @var array<string, int>|null
     */
    public $template_type_uses_count;

    /**
     * @var array<string, bool>
     */
    public $initialized_properties = [];

    /**
     * @var array<string>
     */
    public $invalid_dependencies = [];

    /**
     * @var array<lowercase-string, bool>
     */
    public $dependent_classlikes = [];

    /**
     * A hash of the source file's name, contents, and this file's modified on date
     *
     * @var string
     */
    public $hash = '';

    /**
     * @var bool
     */
    public $has_visitor_issues = false;

    /**
     * @var list<\Psalm\Issue\CodeIssue>
     */
    public $docblock_issues = [];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
}
