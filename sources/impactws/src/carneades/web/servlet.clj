(do (clojure.core/ns carneades.web.servlet (:require ring.util.servlet carneades.web.service) (:gen-class :extends javax.servlet.http.HttpServlet)) (ring.util.servlet/defservice (clojure.core/fn [request__380__auto__] (carneades.web.service/carneades-web-service (clojure.core/assoc request__380__auto__ :path-info (.getPathInfo (:servlet-request request__380__auto__)) :context (.getContextPath (:servlet-request request__380__auto__)))))))
