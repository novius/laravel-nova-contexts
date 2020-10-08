<?php

namespace Novius\LaravelNovaContexts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Novius\Gli\Exceptions\ContextNotFoundException;
use Novius\LaravelNovaContexts\ContextManager;

class ContextController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listContexts(Request $request)
    {
        $contexts = app()->get('context_manager')->contexts(true);

        return response()->json([
            'contexts' => (count($contexts) > 1 ? $contexts : []),
            'error' => 0,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCurrentContext(Request $request)
    {
        try {
            $context = (string) $request->get('context', '');

            if ($context === ContextManager::CONTEXT_KEY_ALL) {
                app()->get('context_manager')->clearCurrentContext();

                return response()->json([
                    'message' => trans('laravel-nova-contexts::contexts.successfully_update_current_context_for_all'),
                    'error' => 0,
                ]);
            }

            app()->get('context_manager')->setCurrentContext($context);

            return response()->json([
                'message' => trans('laravel-nova-contexts::contexts.successfully_update_current_context'),
                'error' => 0,
            ]);
        } catch (ContextNotFoundException $e) {
            return response()->json([
                'message' => trans('laravel-nova-contexts::contexts.unknown_context_update_error'),
                'error' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => 1,
            ]);
        }
    }
}
