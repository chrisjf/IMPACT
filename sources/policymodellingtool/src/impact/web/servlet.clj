(do (clojure.core/ns impact.web.servlet (:require ring.util.servlet impact.web.routes-war) (:gen-class :extends javax.servlet.http.HttpServlet)) (ring.util.servlet/defservice (clojure.core/fn [request__827__auto__] (impact.web.routes-war/impact-app (clojure.core/assoc request__827__auto__ :path-info (.getPathInfo (:servlet-request request__827__auto__)) :context (.getContextPath (:servlet-request request__827__auto__)))))))