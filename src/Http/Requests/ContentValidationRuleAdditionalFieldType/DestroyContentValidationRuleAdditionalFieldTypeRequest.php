<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRuleAdditionalFieldType;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository;

class DestroyContentValidationRuleAdditionalFieldTypeRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository	$repository
	 * @return	void
	 */
	public function __construct(ContentValidationRuleAdditionalFieldTypeRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->authorizeDeveloper() === false)
		{
			return false;
		}

		return $this->authorizeResourceExist();
    }
}
