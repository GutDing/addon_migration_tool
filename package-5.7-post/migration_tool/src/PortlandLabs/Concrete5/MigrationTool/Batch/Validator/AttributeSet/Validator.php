<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator implements ItemValidatorInterface
{

    public function validate(Batch $batch, $set)
    {
        $messages = new MessageCollection();
        $mapper = new Attribute();
        $targetItemList = new TargetItemList($batch, $mapper);
        foreach($set->getAttributes() as $attribute) {
            $item = new Item($attribute);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $messages->add(
                    new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                );
            }
        }
        return $messages;
    }
}