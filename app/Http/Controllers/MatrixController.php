<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\FullMatrix;
use App\Rules\MatrixRange;
use App\Rules\MatrixNumeric;
use App\Services\MatrixHelperService;
use Illuminate\Http\JsonResponse;

class MatrixController extends Controller
{
    protected $helper;

    /**
     * Create a new instance.
     *
     * @param  MatrixHelperService  $users
     * @return void
     */
    public function __construct(MatrixHelperService $helper)
    {
        $this->helper = $helper;
    }


    /**
     * Creates a new matrix product from user input.
     *
     * @param  Request $request
     *
     * @return JsonResponse
     */
    public function getMatrixProduct(Request $request): JsonResponse
    {
        $fullMatrixRule = new FullMatrix;
        $matrixRangeRule = new MatrixRange(1,26);
        $matrixIsNumbericRule = new MatrixNumeric;

        //validate the input
        $validator = Validator::make($request->all(), [
            'firstMatrix'  => [
                'bail',
                'required',
                'array',
                $fullMatrixRule,
                $matrixIsNumbericRule,
                $matrixRangeRule
            ],
            'secondMatrix' => [
                'bail',
                'required',
                'array',
                $fullMatrixRule,
                $matrixIsNumbericRule,
                $matrixRangeRule,
                "size:{$this->getMatrixCount($request, 'firstMatrix')}"
            ]
        ]);

        if($validator->fails()) {
            return response()->json([
                'result' => 'fail',
                'errors' => $validator->errors()], 422);
        }

        //multiply the matrix
        $product = $this->helper->getMultiMatrix(
            $request->firstMatrix,
            $request->secondMatrix,
            1);

        return response()->json([
            'result' => 'success',
            'data' => $product]);
    }

    /**
     * Get the count(number of columns) for the requested Matrix.
     *
     * @param Request $request
     * @param string  $name     The field to use.
     *
     * @return int
     */
    protected function getMatrixCount(Request $request, string $name): int
    {
        return count($request->$name[0]);
    }
}
