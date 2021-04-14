<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector;
use Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector;
use Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateConstantRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\DeadCode\Rector\For_\RemoveDeadLoopRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector;
use Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector;
use Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Property\RemoveSetterOnlyPropertyAndMethodCallRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\PHPUnit\Rector\ClassMethod\RemoveEmptyTestMethodRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // paths to refactor; solid alternative to CLI arguments
    $parameters->set(Option::PATHS, [__DIR__ . '/src']);

    // is your PHP version different from the one your refactor to?
    // [default: your PHP version], uses PHP_VERSION_ID format
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_72);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::CODE_QUALITY_STRICT,
        SetList::PHP_52,
        SetList::PHP_53,
        SetList::PHP_54,
        SetList::PHP_55,
        SetList::PHP_56,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::PSR_4,
        // SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
        // Add sets from PHPUnitSetList
    ]);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    $services->set(UnwrapFutureCompatibleIfFunctionExistsRector::class);
    $services->set(UnwrapFutureCompatibleIfPhpVersionRector::class);
    $services->set(RecastingRemovalRector::class);
    $services->set(RemoveDeadStmtRector::class);
    $services->set(RemoveDuplicatedArrayKeyRector::class);
    $services->set(RemoveUnusedForeachKeyRector::class);
    $services->set(RemoveParentCallWithoutParentRector::class);
    $services->set(RemoveEmptyClassMethodRector::class);
    $services->set(RemoveDoubleAssignRector::class);
    $services->set(SimplifyMirrorAssignRector::class);
    $services->set(RemoveOverriddenValuesRector::class);
    $services->set(RemoveUnusedPrivatePropertyRector::class);
    $services->set(RemoveUnusedPrivateConstantRector::class);
    $services->set(RemoveUnusedPrivateMethodRector::class);
    $services->set(RemoveCodeAfterReturnRector::class);
    $services->set(RemoveDeadConstructorRector::class);
    $services->set(RemoveDeadReturnRector::class);
    $services->set(RemoveDeadIfForeachForRector::class);
    $services->set(RemoveAndTrueRector::class);
    $services->set(RemoveDefaultArgumentValueRector::class);
    $services->set(RemoveConcatAutocastRector::class);
    $services->set(SimplifyUselessVariableRector::class);
    $services->set(RemoveDelegatingParentCallRector::class);
    $services->set(RemoveDuplicatedInstanceOfRector::class);
    $services->set(RemoveDuplicatedCaseInSwitchRector::class);
    $services->set(RemoveSetterOnlyPropertyAndMethodCallRector::class);
    $services->set(RemoveNullPropertyInitializationRector::class);
    $services->set(RemoveUnreachableStatementRector::class);
    $services->set(SimplifyIfElseWithSameContentRector::class);
    $services->set(TernaryToBooleanOrFalseToBooleanAndRector::class);
    $services->set(RemoveEmptyTestMethodRector::class);
    $services->set(RemoveDeadTryCatchRector::class);
    $services->set(RemoveUnusedVariableAssignRector::class);
    $services->set(RemoveDuplicatedIfReturnRector::class);
    $services->set(RemoveUnusedNonEmptyArrayBeforeForeachRector::class);
    $services->set(RemoveAssignOfVoidReturnFunctionRector::class);
    $services->set(RemoveEmptyMethodCallRector::class);
    $services->set(RemoveDeadConditionAboveReturnRector::class);
    $services->set(RemoveUnusedConstructorParamRector::class);
    $services->set(RemoveDeadInstanceOfRector::class);
    $services->set(RemoveDeadLoopRector::class);

    // docblock
    $services->set(RemoveUselessParamTagRector::class);
    // $services->set(RemoveUselessReturnTagRector::class);
    $services->set(RemoveNonExistingVarAnnotationRector::class);
};
